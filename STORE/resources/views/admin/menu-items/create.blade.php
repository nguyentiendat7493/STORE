@extends('admin.layouts.app')

@section('title', 'New Menu Item')

@section('content')
    <div class="panel panel-pad">
        <form method="POST" action="{{ route('admin.menu-items.store', $menu) }}">
            @include('admin.menu-items._form', ['item' => null])
        </form>
    </div>
@endsection
