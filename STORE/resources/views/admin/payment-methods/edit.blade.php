@extends('admin.layouts.app')

@section('title', 'Edit Payment Method')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.payment-methods.update', $paymentMethod) }}">
            @include('admin.payment-methods._form')
        </form>
    </div>
@endsection
