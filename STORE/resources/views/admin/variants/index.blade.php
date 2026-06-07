@extends('admin.layouts.app')

@section('title', 'Variants')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.variants.create') }}">New Variant</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search SKU"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>SKU</th><th>Product</th><th>Size</th><th>Color</th><th>Price</th><th>Stock</th><th>Update Stock</th><th></th></tr></thead>
                <tbody>
                    @forelse ($variants as $variant)
                        <tr>
                            <td>{{ $variant->sku }}</td>
                            <td>{{ $variant->product?->name }}</td>
                            <td>{{ $variant->size?->name }}</td>
                            <td>{{ $variant->color?->name }}</td>
                            <td>{{ $variant->display_price }}</td>
                            <td><span class="badge {{ $variant->stock > 5 ? 'text-bg-success' : 'text-bg-warning' }}">{{ $variant->stock }}</span></td>
                            <td style="width: 190px">
                                <form class="d-flex gap-2" method="POST" action="{{ route('admin.variants.stock', $variant) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input class="form-control form-control-sm" type="number" name="stock" min="0" value="{{ $variant->stock }}">
                                    <button class="btn btn-sm btn-outline-dark" type="submit">Save</button>
                                </form>
                            </td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.variants.edit', $variant) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-muted p-4">No variants found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $variants->links() }}</div>
    </div>
@endsection
