<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    protected function filtered(Request $request)
    {
        return Enquiry::with('handler')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->when($request->source, fn ($q, $v) => $q->where('source', $v))
            ->when($request->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($request->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($request->q, function ($q, $v) {
                $q->where(fn ($w) => $w->where('name', 'like', "%$v%")
                    ->orWhere('mobile', 'like', "%$v%")
                    ->orWhere('email', 'like', "%$v%")
                    ->orWhere('service', 'like', "%$v%"));
            })
            ->latest();
    }

    public function index(Request $request)
    {
        $enquiries = $this->filtered($request)->get();
        $counts = Enquiry::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.enquiries.index', compact('enquiries', 'counts'));
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Enquiry::STATUSES))],
            'notes'  => ['nullable', 'string', 'max:5000'],
        ]);
        $data['handled_by'] = $request->user()->id;
        $enquiry->update($data);

        if ($request->expectsJson()) {
            return response()->json(['status' => true, 'message' => 'Enquiry updated.']);
        }
        return back()->with('success', 'Enquiry updated.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }

    public function export(Request $request)
    {
        $rows = $this->filtered($request)->get();
        $name = 'sswf-enquiries-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel opens Tamil/unicode correctly
            fputcsv($out, ['Date', 'Name', 'Mobile', 'Email', 'Address', 'Service', 'Message', 'Form', 'Status', 'Notes', 'Handled by']);
            foreach ($rows as $e) {
                fputcsv($out, [
                    $e->created_at->format('d-m-Y h:i A'), $e->name, $e->mobile, $e->email, $e->address,
                    $e->service, $e->message, Enquiry::SOURCES[$e->source] ?? $e->source,
                    $e->statusLabel(), $e->notes, optional($e->handler)->name,
                ]);
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
