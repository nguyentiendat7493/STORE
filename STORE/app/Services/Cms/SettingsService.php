<?php

namespace App\Services\Cms;

use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public function __construct(
        private readonly SettingRepositoryInterface $settings,
    ) {
    }

    public function public(?string $group = null): Collection
    {
        $cacheKey = 'settings.public.'.($group ?: 'all');

        return Cache::remember($cacheKey, now()->addHour(), fn () => $this->settings->public($group));
    }

    public function value(string $key, mixed $default = null): mixed
    {
        return Cache::remember("settings.value.{$key}", now()->addHour(), fn () => $this->settings->value($key, $default));
    }

    public function updateMany(array $settings): void
    {
        $this->settings->updateMany($settings);
        Cache::flush();
    }
}
