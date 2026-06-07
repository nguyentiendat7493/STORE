@extends('admin.layouts.app')

@section('title', 'Menus')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.menus.create') }}">New Menu</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search menus"></div>
            <div class="col-lg-3">
                <select class="form-select" name="location">
                    <option value="">All locations</option>
                    @foreach (['header', 'footer_service', 'footer_account'] as $location)
                        <option value="{{ $location }}" @selected(request('location') === $location)>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
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
                <thead><tr><th>Name</th><th>Slug</th><th>Location</th><th>Items</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td class="fw-semibold">{{ $menu->name }}</td>
                            <td>{{ $menu->slug }}</td>
                            <td>{{ $menu->location }}</td>
                            <td>{{ $menu->all_items_count }}</td>
                            <td><span class="badge {{ $menu->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $menu->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.menus.edit', $menu) }}">Manage</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.menus.destroy', $menu) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No menus found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $menus->links() }}</div>
    </div>
@endsection
