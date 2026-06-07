@extends('admin.layouts.app')

@section('title', 'New Notification')

@section('content')
    <div class="panel panel-pad" style="max-width: 860px">
        <form method="POST" action="{{ route('admin.notifications.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-lg-6">
                    <label class="form-label">Recipient</label>
                    <select class="form-select" name="user_id">
                        <option value="">System / all users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} · {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="type" required>
                        @foreach (['system', 'order', 'coupon', 'review', 'promotion'] as $type)
                            <option value="{{ $type }}" @selected(old('type', 'system') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" value="{{ old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" name="message" rows="5">{{ old('message') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Action URL</label>
                    <input class="form-control" name="data_url" value="{{ old('data_url') }}" placeholder="/orders/1">
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-dark" type="submit">Send Notification</button>
                <a class="btn btn-outline-dark" href="{{ route('admin.notifications.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
