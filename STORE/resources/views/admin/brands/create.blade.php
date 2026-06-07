@extends('admin.layouts.app')

@section('title', 'New Brand')

@section('content')
    <div class="panel panel-pad" style="max-width: 760px">
        <form method="POST" action="{{ route('admin.brands.store') }}">
            @include('admin.brands._form', ['brand' => null])
        </form>
    </div>
@endsection
