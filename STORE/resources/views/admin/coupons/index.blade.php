@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.coupons.create') }}">New Coupon</a>
    </div>
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search coupon code"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Code</th><th>Type</th><th>Discount</th><th>Start</th><th>End</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->discount_type }}</td>
                            <td>{{ $coupon->display_discount }}</td>
                            <td>{{ $coupon->start_date?->format('Y-m-d') }}</td>
                            <td>{{ $coupon->end_date?->format('Y-m-d') }}</td>
                            <td><span class="badge {{ $coupon->status ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $coupon->status ? 'Active' : 'Hidden' }}</span></td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.coupons.edit', $coupon) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No coupons found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $coupons->links() }}</div>
    </div>
@endsection
