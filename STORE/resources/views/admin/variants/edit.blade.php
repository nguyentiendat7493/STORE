@extends('admin.layouts.app')

@section('title', 'Edit Variant')

@section('content')
    <div class="panel panel-pad" style="max-width: 860px">
        <form method="POST" action="{{ route('admin.variants.update', $variant) }}">
            @include('admin.variants._form')
        </form>
    </div>
@endsection
