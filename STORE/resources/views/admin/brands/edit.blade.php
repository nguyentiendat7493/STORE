@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.brands.update', $brand) }}">
            @include('admin.brands._form')
        </form>
    </div>
@endsection
