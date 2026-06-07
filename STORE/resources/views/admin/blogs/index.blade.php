@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.blogs.create') }}">New Blog Post</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search posts"></div>
            <div class="col-lg-3">
                <select class="form-select" name="blog_category_id">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('blog_category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Post</th><th>Category</th><th>Author</th><th>Status</th><th>Published</th><th></th></tr></thead>
                <tbody>
                    @forelse ($blogs as $blog)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $blog->title }}</div>
                                <div class="text-muted small">{{ $blog->slug }}</div>
                            </td>
                            <td>{{ $blog->category?->name }}</td>
                            <td>{{ $blog->author?->name }}</td>
                            <td><span class="badge {{ $blog->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $blog->status }}</span></td>
                            <td>{{ $blog->published_at?->format('Y-m-d H:i') ?: '-' }}</td>
                            <td class="text-end">
                                @if ($blog->status === 'published')
                                    <a class="btn btn-sm btn-outline-dark" href="{{ route('blogs.show', $blog) }}" target="_blank">View</a>
                                @endif
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.blogs.edit', $blog) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.blogs.destroy', $blog) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No blog posts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $blogs->links() }}</div>
    </div>
@endsection
