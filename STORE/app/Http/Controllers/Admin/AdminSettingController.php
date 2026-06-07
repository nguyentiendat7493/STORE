<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\Cms\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingController extends Controller
{
    public function __construct(
        private readonly SettingsService $settings,
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $activeGroup = $request->string('group')->toString();
        $groups = Setting::query()
            ->select('group_name')
            ->distinct()
            ->orderBy('group_name')
            ->pluck('group_name');

        $settings = Setting::query()
            ->group($activeGroup ?: null)
            ->orderBy('group_name')
            ->orderBy('key')
            ->get()
            ->groupBy('group_name');

        return view('admin.settings.index', compact('settings', 'groups', 'activeGroup'));
    }

    public function update(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $validated = $request->validate([
            'settings' => ['array'],
            'settings.*' => ['nullable'],
        ]);

        $this->settings->updateMany($validated['settings'] ?? []);

        return back()->with('success', 'Settings updated.');
    }
}
