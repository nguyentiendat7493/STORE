@extends('admin.layouts.app')

@section('title', 'New Size')

@section('content')
    <div class="panel panel-pad" style="max-width: 520px">
        <form method="POST" action="{{ route('admin.sizes.store') }}">
            @include('admin.sizes._form', ['size' => null])
        </form>
    </div>
@endsection
