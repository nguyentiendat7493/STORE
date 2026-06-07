@extends('admin.layouts.app')

@section('title', 'New Shipping Method')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.shipping-methods.store') }}">
            @include('admin.shipping-methods._form', ['shippingMethod' => null])
        </form>
    </div>
@endsection
