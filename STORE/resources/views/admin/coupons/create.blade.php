@extends('admin.layouts.app')

@section('title', 'New Coupon')

@section('content')
    <div class="panel panel-pad" style="max-width: 860px">
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @include('admin.coupons._form', ['coupon' => null])
        </form>
    </div>
@endsection
