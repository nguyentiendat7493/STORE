@extends('admin.layouts.app')

@section('title', 'Edit Menu Item')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.menu-items.update', $item) }}">
            @include('admin.menu-items._form')
        </form>
    </div>
@endsection
