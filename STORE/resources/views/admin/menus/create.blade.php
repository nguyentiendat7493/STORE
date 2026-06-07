@extends('admin.layouts.app')

@section('title', 'New Menu')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.menus.store') }}">
            @include('admin.menus._form', ['menu' => null])
        </form>
    </div>
@endsection
