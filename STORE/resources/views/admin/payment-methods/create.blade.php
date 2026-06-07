@extends('admin.layouts.app')

@section('title', 'New Payment Method')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.payment-methods.store') }}">
            @include('admin.payment-methods._form', ['paymentMethod' => null])
        </form>
    </div>
@endsection
