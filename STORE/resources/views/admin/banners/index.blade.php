@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.banners.create') }}">New Banner</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search banners"></div>
            <div class="col-lg-3">
                <select class="form-select" name="position">
                    <option value="">All positions</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position }}" @selected(request('position') === $position)>{{ $position }}</option>
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
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Order</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banners as $banner)
                        <tr>
                            <td style="width: 140px">
                                @if ($banner->image)
                                    <img class="w-100 border" style="aspect-ratio: 16 / 9; object-fit: cover" src="{{ str_starts_with($banner->image, 'http') ? $banner->image : asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
                                @else
                                    <div class="bg-light border" style="width: 120px; aspect-ratio: 16 / 9"></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $banner->title }}</div>
                                <div class="text-muted small">{{ $banner->subtitle }}</div>
                            </td>
                            <td>{{ $banner->position }}</td>
                            <td>{{ $banner->sort_order }}</td>
                            <td class="small">
                                <div>{{ $banner->starts_at?->format('Y-m-d H:i') ?: 'No start' }}</div>
                                <div>{{ $banner->ends_at?->format('Y-m-d H:i') ?: 'No end' }}</div>
                            </td>
                            <td><span class="badge {{ $banner->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $banner->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.banners.edit', $banner) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.banners.destroy', $banner) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No banners found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $banners->links() }}</div>
    </div>
@endsection
