@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
            @include('admin.banners._form')
        </form>
    </div>
@endsection
