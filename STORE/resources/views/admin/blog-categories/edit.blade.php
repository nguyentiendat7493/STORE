@extends('admin.layouts.app')

@section('title', 'Edit Blog Category')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.blog-categories.update', $blogCategory) }}">
            @include('admin.blog-categories._form')
        </form>
    </div>
@endsection
