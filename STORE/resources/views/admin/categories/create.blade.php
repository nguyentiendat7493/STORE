@extends('admin.layouts.app')

@section('title', 'New Category')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @include('admin.categories._form', ['category' => null])
        </form>
    </div>
@endsection
