@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.products.create') }}">New Product</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-4"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search products"></div>
            <div class="col-lg-3">
                <select class="form-select" name="category_id">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <select class="form-select" name="brand_id">
                    <option value="">All brands</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(request('brand_id') == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Product</th><th>Category</th><th>Brand</th><th>Price</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                <div class="text-muted small">{{ $product->slug }}</div>
                            </td>
                            <td>{{ $product->category?->name }}</td>
                            <td>{{ $product->brand?->name }}</td>
                            <td>{{ $product->display_price }}</td>
                            <td><span class="badge {{ $product->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $product->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.products.show', $product) }}">View</a>
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $products->links() }}</div>
    </div>
@endsection
