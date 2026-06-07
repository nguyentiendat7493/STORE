<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    public function public(?string $group = null): Collection
    {
        return Setting::query()
            ->public()
            ->group($group)
            ->orderBy('group_name')
            ->orderBy('key')
            ->get();
    }

    public function value(string $key, mixed $default = null): mixed
    {
        return Setting::query()->where('key', $key)->value('value') ?? $default;
    }

    public function updateMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::query()->where('key', $key)->update(['value' => $value]);
        }
    }
}
