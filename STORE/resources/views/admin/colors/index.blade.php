@extends('admin.layouts.app')

@section('title', 'Colors')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.colors.create') }}">New Color</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search colors"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Name</th><th>Swatch</th><th></th></tr></thead>
            <tbody>
                @forelse ($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            @if ($color->hex_code)
                                <span class="d-inline-block border" style="width: 28px; height: 28px; background: {{ $color->hex_code }}"></span>
                                <span class="ms-2 text-muted">{{ $color->hex_code }}</span>
                            @endif
                        </td>
                        <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.colors.edit', $color) }}">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted p-4">No colors found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="panel-pad">{{ $colors->links() }}</div>
    </div>
@endsection
