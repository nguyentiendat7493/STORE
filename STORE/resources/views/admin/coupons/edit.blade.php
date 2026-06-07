@extends('admin.layouts.app')

@section('title', 'Edit Coupon')

@section('content')
    <div class="panel panel-pad" style="max-width: 860px">
        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
            @include('admin.coupons._form')
        </form>
    </div>
@endsection
