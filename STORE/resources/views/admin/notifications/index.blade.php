@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.notifications.create') }}">New Notification</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-4"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search notifications"></div>
            <div class="col-lg-3">
                <select class="form-select" name="user_id">
                    <option value="">All recipients</option>
                    <option value="">System / all users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->name }} · {{ $user->email }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <select class="form-select" name="type">
                    <option value="">All types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-1">
                <select class="form-select" name="unread">
                    <option value="">All</option>
                    <option value="1" @selected(request('unread') === '1')>Unread</option>
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Notification</th><th>Recipient</th><th>Type</th><th>Status</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($notifications as $notification)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $notification->title }}</div>
                                <div class="text-muted small">{{ str($notification->message)->limit(90) }}</div>
                            </td>
                            <td>{{ $notification->user ? $notification->user->name : 'System / all users' }}</td>
                            <td>{{ $notification->type }}</td>
                            <td><span class="badge {{ $notification->read_at ? 'text-bg-secondary' : 'text-bg-warning' }}">{{ $notification->read_at ? 'Read' : 'Unread' }}</span></td>
                            <td>{{ $notification->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.notifications.show', $notification) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No notifications found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $notifications->links() }}</div>
    </div>
@endsection
