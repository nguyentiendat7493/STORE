@extends('admin.layouts.app')

@section('title', 'Edit Shipping Method')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.shipping-methods.update', $shippingMethod) }}">
            @include('admin.shipping-methods._form')
        </form>
    </div>
@endsection
