@extends('admin.layouts.app')

@section('title', 'Edit Size')

@section('content')
    <div class="panel panel-pad" style="max-width: 520px">
        <form method="POST" action="{{ route('admin.sizes.update', $size) }}">
            @include('admin.sizes._form')
        </form>
    </div>
@endsection
