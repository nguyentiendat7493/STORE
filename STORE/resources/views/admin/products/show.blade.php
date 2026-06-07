@extends('admin.layouts.app')

@section('title', 'Product Detail')

@section('content')
    <div class="row g-4">
        <div class="col-xl-5">
            <div class="panel panel-pad">
                <h2 class="h4">{{ $product->name }}</h2>
                <p class="text-muted mb-3">{{ $product->description }}</p>
                <dl class="row mb-0">
                    <dt class="col-4">Category</dt><dd class="col-8">{{ $product->category?->name }}</dd>
                    <dt class="col-4">Brand</dt><dd class="col-8">{{ $product->brand?->name }}</dd>
                    <dt class="col-4">Gender</dt><dd class="col-8">{{ $product->gender }}</dd>
                    <dt class="col-4">Price</dt><dd class="col-8">{{ $product->display_price }}</dd>
                    <dt class="col-4">Status</dt><dd class="col-8">{{ $product->status ? 'Active' : 'Hidden' }}</dd>
                </dl>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="panel">
                <div class="panel-pad border-bottom"><h2 class="h5 mb-0">Variants</h2></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>SKU</th><th>Size</th><th>Color</th><th>Price</th><th>Stock</th></tr></thead>
                        <tbody>
                            @forelse ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->sku }}</td>
                                    <td>{{ $variant->size?->name }}</td>
                                    <td>{{ $variant->color?->name }}</td>
                                    <td>{{ $variant->display_price }}</td>
                                    <td>{{ $variant->stock }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-muted p-4">No variants.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
