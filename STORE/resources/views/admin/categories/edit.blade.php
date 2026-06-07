@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @include('admin.categories._form')
        </form>
    </div>
@endsection
