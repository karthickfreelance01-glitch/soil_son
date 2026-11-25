<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    use UploadsImages;

    public function index(Request $request)
    {
        $items = GalleryItem::when($request->category, fn ($q, $c) => $q->where('category', $c))
            ->orderBy('sort_order')->orderByDesc('id')->get();
        $categories = GalleryItem::distinct()->orderBy('category')->pluck('category');

        return view('admin.gallery.index', compact('items', 'categories'));
    }

    /** Upload one or many photos at once. */
    public function store(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array', 'max:30'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'category' => ['required', 'string', 'max:60'],
            'title'    => ['nullable', 'string', 'max:150'],
        ], ['images.*.max' => 'Each photo must be 5 MB or smaller.']);

        $next = (int) GalleryItem::max('sort_order');
        foreach ($request->file('images') as $file) {
            $title = $request->title ?: Str::headline(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            GalleryItem::create([
                'title'      => $title,
                'image'      => $this->storeImage($file, 'gallery'),
                'category'   => trim($request->category),
                'alt_text'   => $title.' - '.config('site.name'),
                'sort_order' => ++$next,
                'is_active'  => true,
            ]);
        }

        return back()->with('success', count($request->file('images')).' photo(s) uploaded.');
    }

    public function update(Request $request, GalleryItem $item)
    {
        $data = $request->validate([
            'title'      => ['nullable', 'string', 'max:150'],
            'category'   => ['required', 'string', 'max:60'],
            'alt_text'   => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        if ($request->hasFile('image_file')) {
            $this->deleteImage($item->image);
            $data['image'] = $this->storeImage($request->file('image_file'), 'gallery');
        }
        unset($data['image_file']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? $item->sort_order;
        $item->update($data);

        return back()->with('success', 'Photo updated.');
    }

    public function toggle(GalleryItem $item)
    {
        $item->update(['is_active' => ! $item->is_active]);
        return response()->json(['status' => true, 'active' => $item->is_active]);
    }

    public function destroy(GalleryItem $item)
    {
        $this->deleteImage($item->image);
        $item->delete();

        return back()->with('success', 'Photo deleted.');
    }
}
