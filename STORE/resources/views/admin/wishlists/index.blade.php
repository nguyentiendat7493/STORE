@extends('admin.layouts.app')

@section('title', 'Wishlists')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-xl-5">
            <div class="panel">
                <div class="panel-pad border-bottom">
                    <h2 class="h5 mb-0">Top Wishlisted Products</h2>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Product</th><th>Likes</th></tr></thead>
                        <tbody>
                            @forelse ($topProducts as $item)
                                <tr>
                                    <td>{{ $item->product?->name }}</td>
                                    <td><span class="badge text-bg-light">{{ $item->wishlist_count }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-muted p-4">No wishlist data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="panel panel-pad h-100">
                <form class="row g-2" method="GET">
                    <div class="col-lg-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search product name"></div>
                    <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Customer</th><th>Product</th><th>Category</th><th>Brand</th><th>Created</th></tr></thead>
                <tbody>
                    @forelse ($wishlists as $wishlist)
                        <tr>
                            <td>{{ $wishlist->user?->name }}<div class="text-muted small">{{ $wishlist->user?->email }}</div></td>
                            <td>{{ $wishlist->product?->name }}</td>
                            <td>{{ $wishlist->product?->category?->name }}</td>
                            <td>{{ $wishlist->product?->brand?->name }}</td>
                            <td>{{ $wishlist->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted p-4">No wishlist records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $wishlists->links() }}</div>
    </div>
@endsection
