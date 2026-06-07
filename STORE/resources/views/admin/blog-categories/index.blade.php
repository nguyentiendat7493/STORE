@extends('admin.layouts.app')

@section('title', 'Blog Categories')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.blog-categories.create') }}">New Blog Category</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-8"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search blog categories"></div>
            <div class="col-lg-2">
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    <option value="1" @selected(request('status') === '1')>Active</option>
                    <option value="0" @selected(request('status') === '0')>Hidden</option>
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($blogCategories as $category)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $category->name }}</div>
                                <div class="text-muted small">{{ $category->description }}</div>
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->blogs_count }}</td>
                            <td><span class="badge {{ $category->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $category->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.blog-categories.edit', $category) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.blog-categories.destroy', $category) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted p-4">No blog categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $blogCategories->links() }}</div>
    </div>
@endsection
