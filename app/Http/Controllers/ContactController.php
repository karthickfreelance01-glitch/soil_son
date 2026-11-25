<?php

namespace App\Http\Controllers;

use App\Support\EnquiryRecorder;
use App\Support\SiteData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact', ['active' => 'contact']);
    }

    public function store(Request $request)
    {
        /* "website" is the honeypot field: humans never see it, bots fill it. */
        if (filled($request->input('website'))) {
            return back()->with('contact_success', config('site.contact_success'));
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'mobile'  => ['required', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'email'   => ['required', 'email:rfc', 'max:150'],
            'address' => ['required', 'string', 'max:255'],
            'service' => ['required', Rule::in(array_unique(array_merge(SiteData::DEFAULT_SERVICES, SiteData::serviceNames())))],
        ], [
            'mobile.regex' => 'Please enter a valid mobile number.',
            'service.in'   => 'Please choose one of the listed services.',
        ]);

        EnquiryRecorder::record($data, 'contact', $request);

        return redirect()
            ->route('contact')
            ->with('contact_success', config('site.contact_success'));
    }
}
