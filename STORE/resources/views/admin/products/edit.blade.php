@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @include('admin.products._form')
        </form>
    </div>
@endsection
