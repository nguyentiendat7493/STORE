@extends('admin.layouts.app')

@section('title', 'Review Detail')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="panel panel-pad">
                <div class="d-flex justify-content-between gap-3 mb-3">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Product</div>
                        <h2 class="h4 mb-0">{{ $review->product?->name }}</h2>
                    </div>
                    <div class="text-warning fs-4">{{ str_repeat('★', $review->rating) }}<span class="text-muted">{{ str_repeat('☆', 5 - $review->rating) }}</span></div>
                </div>

                <p class="fs-5 lh-lg mb-4">{{ $review->comment ?: 'No comment provided.' }}</p>

                <dl class="row mb-0">
                    <dt class="col-sm-3">Customer</dt><dd class="col-sm-9">{{ $review->user?->name }} · {{ $review->user?->email }}</dd>
                    <dt class="col-sm-3">Order</dt><dd class="col-sm-9">{{ $review->order_id ? '#'.$review->order_id : 'No linked order' }}</dd>
                    <dt class="col-sm-3">Created</dt><dd class="col-sm-9">{{ $review->created_at?->format('Y-m-d H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel panel-pad">
                <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Status</label>
                    <select class="form-select mb-3" name="status">
                        @foreach (['pending', 'approved', 'hidden'] as $status)
                            <option value="{{ $status }}" @selected($review->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-dark w-100" type="submit">Update Review</button>
                </form>

                <form class="mt-3" method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100" type="submit">Delete Review</button>
                </form>
            </div>
        </div>
    </div>
@endsection
