<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Blog::published()
            ->with(['category', 'author'])
            ->search($request->string('q')->toString())
            ->filter($request->only(['blog_category_id']))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = BlogCategory::active()
            ->withCount(['blogs' => fn ($query) => $query->published()])
            ->orderBy('name')
            ->get();

        return view('blogs.index', compact('posts', 'categories'));
    }

    public function show(Blog $blog): View
    {
        abort_if(! Blog::published()->whereKey($blog->id)->exists(), 404);

        $blog->load(['category', 'author']);

        $relatedPosts = Blog::published()
            ->whereKeyNot($blog->id)
            ->when($blog->blog_category_id, fn ($query) => $query->where('blog_category_id', $blog->blog_category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedPosts'));
    }
}
