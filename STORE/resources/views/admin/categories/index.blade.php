@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.categories.create') }}">New Category</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search categories"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Status</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td><span class="badge {{ $category->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $category->status ? 'Active' : 'Hidden' }}</span></td>
                            <td>{{ $category->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.categories.edit', $category) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $categories->links() }}</div>
    </div>
@endsection
