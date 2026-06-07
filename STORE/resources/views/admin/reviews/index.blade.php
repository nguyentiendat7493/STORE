@extends('admin.layouts.app')

@section('title', 'Reviews')

@section('content')
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search comments"></div>
            <div class="col-lg-2">
                <select class="form-select" name="rating">
                    <option value="">All ratings</option>
                    @for ($rating = 5; $rating >= 1; $rating--)
                        <option value="{{ $rating }}" @selected(request('rating') == $rating)>{{ $rating }} stars</option>
                    @endfor
                </select>
            </div>
            <div class="col-lg-3">
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'hidden'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Review</th><th>Product</th><th>Customer</th><th>Rating</th><th>Status</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td style="min-width: 260px">
                                <div class="fw-semibold">{{ str($review->comment)->limit(90) }}</div>
                            </td>
                            <td>{{ $review->product?->name }}</td>
                            <td>{{ $review->user?->name }}</td>
                            <td>
                                <span class="text-warning">{{ str_repeat('★', $review->rating) }}</span><span class="text-muted">{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </td>
                            <td><span class="badge {{ $review->status === 'approved' ? 'text-bg-success' : ($review->status === 'hidden' ? 'text-bg-secondary' : 'text-bg-warning') }}">{{ $review->status }}</span></td>
                            <td>{{ $review->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.reviews.show', $review) }}">Moderate</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No reviews found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $reviews->links() }}</div>
    </div>
@endsection
