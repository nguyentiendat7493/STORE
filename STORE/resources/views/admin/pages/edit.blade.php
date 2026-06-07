@extends('admin.layouts.app')

@section('title', 'Edit Page')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
            @include('admin.pages._form')
        </form>
    </div>
@endsection
