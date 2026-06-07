@extends('admin.layouts.app')

@section('title', 'Sizes')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.sizes.create') }}">New Size</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search sizes"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Name</th><th></th></tr></thead>
            <tbody>
                @forelse ($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->name }}</td>
                        <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.sizes.edit', $size) }}">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted p-4">No sizes found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="panel-pad">{{ $sizes->links() }}</div>
    </div>
@endsection
