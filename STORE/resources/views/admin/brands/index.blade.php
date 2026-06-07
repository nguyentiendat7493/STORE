@extends('admin.layouts.app')

@section('title', 'Brands')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.brands.create') }}">New Brand</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search brands"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Status</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td><span class="badge {{ $brand->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $brand->status ? 'Active' : 'Hidden' }}</span></td>
                            <td>{{ $brand->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.brands.edit', $brand) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No brands found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $brands->links() }}</div>
    </div>
@endsection
