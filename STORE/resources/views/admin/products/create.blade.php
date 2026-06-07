@extends('admin.layouts.app')

@section('title', 'New Product')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @include('admin.products._form', ['product' => null])
        </form>
    </div>
@endsection
