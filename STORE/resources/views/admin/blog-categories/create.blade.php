@extends('admin.layouts.app')

@section('title', 'New Blog Category')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.blog-categories.store') }}">
            @include('admin.blog-categories._form', ['blogCategory' => null])
        </form>
    </div>
@endsection
