@extends('admin.layouts.app')

@section('title', 'Edit Color')

@section('content')
    <div class="panel panel-pad" style="max-width: 520px">
        <form method="POST" action="{{ route('admin.colors.update', $color) }}">
            @include('admin.colors._form')
        </form>
    </div>
@endsection
