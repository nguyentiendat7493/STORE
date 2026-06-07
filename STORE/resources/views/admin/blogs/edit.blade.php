@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
            @include('admin.blogs._form')
        </form>
    </div>
@endsection
