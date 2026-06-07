@extends('admin.layouts.app')

@section('title', 'New Blog Post')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
            @include('admin.blogs._form', ['blog' => null])
        </form>
    </div>
@endsection
