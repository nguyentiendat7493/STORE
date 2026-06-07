<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    public function public(?string $group = null): Collection;

    public function value(string $key, mixed $default = null): mixed;

    public function updateMany(array $settings): void;
}
