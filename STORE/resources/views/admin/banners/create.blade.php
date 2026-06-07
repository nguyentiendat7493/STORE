@extends('admin.layouts.app')

@section('title', 'New Banner')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
            @include('admin.banners._form', ['banner' => null])
        </form>
    </div>
@endsection
