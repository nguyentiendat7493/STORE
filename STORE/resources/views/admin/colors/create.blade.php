@extends('admin.layouts.app')

@section('title', 'New Color')

@section('content')
    <div class="panel panel-pad" style="max-width: 520px">
        <form method="POST" action="{{ route('admin.colors.store') }}">
            @include('admin.colors._form', ['color' => null])
        </form>
    </div>
@endsection
