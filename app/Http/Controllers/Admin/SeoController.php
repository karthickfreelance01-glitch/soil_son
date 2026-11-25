<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use App\Support\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    use UploadsImages;

    public function index()
    {
        $pages = SeoPage::orderBy('id')->get();
        return view('admin.seo.index', compact('pages'));
    }

    public function update(Request $request, SeoPage $page)
    {
        $data = $request->validate([
            'meta_title'       => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:320'],
            'meta_keywords'    => ['nullable', 'string', 'max:255'],
            'og_image_file'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        if ($request->hasFile('og_image_file')) {
            $this->deleteImage($page->og_image);
            $data['og_image'] = $this->storeImage($request->file('og_image_file'), 'seo');
        }
        unset($data['og_image_file']);
        $data['noindex'] = $request->boolean('noindex');
        $page->update($data);
        Seo::forget($page->page_key);

        return back()->with('success', 'SEO for "'.$page->page_name.'" saved.');
    }
}
