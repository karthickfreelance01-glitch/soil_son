<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    use UploadsImages;

    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service(['is_active' => true, 'icon' => 'fa-hand-holding-heart'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image_file')) {
            $data['image'] = $this->storeImage($request->file('image_file'), 'services');
        }
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service added.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request, $service);
        if ($request->hasFile('image_file')) {
            $this->deleteImage($service->image);
            $data['image'] = $this->storeImage($request->file('image_file'), 'services');
        }
        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $this->deleteImage($service->image);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    public function toggle(Service $service)
    {
        $service->update(['is_active' => ! $service->is_active]);
        return response()->json(['status' => true, 'active' => $service->is_active]);
    }

    protected function validated(Request $request, ?Service $service = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);

        $data = $request->validate([
            'title'             => ['required', 'string', 'max:150'],
            'slug'              => ['required', 'string', 'max:160', Rule::unique('services', 'slug')->ignore($service?->id)],
            'icon'              => ['nullable', 'string', 'max:60'],
            'short_description' => ['nullable', 'string', 'max:300'],
            'content'           => ['nullable', 'string'],
            'link_url'          => ['nullable', 'string', 'max:255'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:320'],
            'meta_keywords'     => ['nullable', 'string', 'max:255'],
            'image_file'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        unset($data['image_file']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
