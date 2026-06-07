@extends('admin.layouts.app')

@section('title', 'Manage Menu')

@section('content')
    <div class="panel panel-pad mb-4">
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}">
            @include('admin.menus._form')
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Menu Items</h2>
        <a class="btn btn-dark" href="{{ route('admin.menu-items.create', $menu) }}">New Item</a>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Title</th><th>URL</th><th>Parent</th><th>Target</th><th>Order</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($menu->allItems->sortBy('sort_order') as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->parent_id ? '— ' : '' }}{{ $item->title }}</td>
                            <td>{{ $item->url }}</td>
                            <td>{{ $item->parent?->title ?: '-' }}</td>
                            <td>{{ $item->target }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td><span class="badge {{ $item->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.menu-items.edit', $item) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.menu-items.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No menu items yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
