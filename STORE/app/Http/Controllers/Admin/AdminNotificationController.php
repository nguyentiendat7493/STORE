<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $notifications = Notification::query()
            ->with('user')
            ->search($request->string('q')->toString())
            ->filter($request->only(['user_id', 'type', 'unread']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        $types = Notification::query()->select('type')->distinct()->orderBy('type')->pluck('type');

        return view('admin.notifications.index', compact('notifications', 'users', 'types'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'type' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:200'],
            'message' => ['nullable', 'string'],
            'data_url' => ['nullable', 'string', 'max:255'],
        ]);

        Notification::create([
            'user_id' => $data['user_id'] ?? null,
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'] ?? null,
            'data' => filled($data['data_url'] ?? null) ? ['url' => $data['data_url']] : null,
            'read_at' => null,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification created.');
    }

    public function show(Request $request, Notification $notification): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $notification->load('user');

        return view('admin.notifications.show', compact('notification'));
    }

    public function update(Request $request, Notification $notification): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $request->validate([
            'read' => ['required', 'boolean'],
        ]);

        $notification->update([
            'read_at' => $data['read'] ? now() : null,
        ]);

        return back()->with('success', 'Notification updated.');
    }

    public function destroy(Request $request, Notification $notification): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted.');
    }
}
