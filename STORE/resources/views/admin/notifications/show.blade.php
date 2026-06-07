@extends('admin.layouts.app')

@section('title', 'Notification Detail')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="panel panel-pad">
                <div class="text-muted small text-uppercase fw-bold">{{ $notification->type }}</div>
                <h2 class="h4 mb-3">{{ $notification->title }}</h2>
                <p class="fs-5 lh-lg">{{ $notification->message }}</p>
                @if (! empty($notification->data['url']))
                    <a class="btn btn-outline-dark" href="{{ $notification->data['url'] }}">Open Action URL</a>
                @endif
                <dl class="row mt-4 mb-0">
                    <dt class="col-sm-3">Recipient</dt><dd class="col-sm-9">{{ $notification->user ? $notification->user->name.' · '.$notification->user->email : 'System / all users' }}</dd>
                    <dt class="col-sm-3">Read at</dt><dd class="col-sm-9">{{ $notification->read_at?->format('Y-m-d H:i') ?: 'Unread' }}</dd>
                    <dt class="col-sm-3">Created</dt><dd class="col-sm-9">{{ $notification->created_at?->format('Y-m-d H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel panel-pad">
                <form method="POST" action="{{ route('admin.notifications.update', $notification) }}">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Read status</label>
                    <select class="form-select mb-3" name="read">
                        <option value="0" @selected(! $notification->read_at)>Unread</option>
                        <option value="1" @selected((bool) $notification->read_at)>Read</option>
                    </select>
                    <button class="btn btn-dark w-100" type="submit">Update Status</button>
                </form>
                <form class="mt-3" method="POST" action="{{ route('admin.notifications.destroy', $notification) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100" type="submit">Delete Notification</button>
                </form>
            </div>
        </div>
    </div>
@endsection
