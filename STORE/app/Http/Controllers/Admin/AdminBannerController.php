<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminBannerController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $banners = Banner::query()
            ->search($request->string('q')->toString())
            ->filter($request->only(['position', 'status']))
            ->orderBy('position')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $positions = Banner::query()
            ->select('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        return view('admin.banners.index', compact('banners', 'positions'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.banners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['status'] = $request->boolean('status', true);
        $data['image'] = $this->storeImage($request) ?: $data['image'];

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created.');
    }

    public function edit(Request $request, Banner $banner): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['status'] = $request->boolean('status');

        if ($path = $this->storeImage($request)) {
            if ($banner->image && ! str_starts_with($banner->image, 'http')) {
                Storage::disk('public')->delete($banner->image);
            }

            $data['image'] = $path;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated.');
    }

    public function destroy(Request $request, Banner $banner): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        if ($banner->image && ! str_starts_with($banner->image, 'http')) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return back()->with('success', 'Banner deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image_file')) {
            return null;
        }

        return $request->file('image_file')->store('banners', 'public');
    }
}
