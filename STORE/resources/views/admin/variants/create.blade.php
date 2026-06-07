@extends('admin.layouts.app')

@section('title', 'New Variant')

@section('content')
    <div class="panel panel-pad" style="max-width: 860px">
        <form method="POST" action="{{ route('admin.variants.store') }}">
            @include('admin.variants._form', ['variant' => null])
        </form>
    </div>
@endsection
