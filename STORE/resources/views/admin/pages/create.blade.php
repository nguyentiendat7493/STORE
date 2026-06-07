@extends('admin.layouts.app')

@section('title', 'New Page')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.pages.store') }}">
            @include('admin.pages._form', ['page' => null])
        </form>
    </div>
@endsection
