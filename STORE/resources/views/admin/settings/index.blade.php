@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="panel panel-pad mb-3">
        <div class="d-flex flex-wrap gap-2">
            <a @class(['btn btn-sm', 'btn-dark' => $activeGroup === '', 'btn-outline-dark' => $activeGroup !== '']) href="{{ route('admin.settings.index') }}">All</a>
            @foreach ($groups as $group)
                <a @class(['btn btn-sm', 'btn-dark' => $activeGroup === $group, 'btn-outline-dark' => $activeGroup !== $group]) href="{{ route('admin.settings.index', ['group' => $group]) }}">
                    {{ ucfirst(str_replace('_', ' ', $group)) }}
                </a>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="d-grid gap-4">
            @forelse ($settings as $groupName => $groupSettings)
                <section class="panel">
                    <div class="panel-pad border-bottom">
                        <div class="text-muted small text-uppercase fw-bold">Group</div>
                        <h2 class="h5 mb-0">{{ ucfirst(str_replace('_', ' ', $groupName)) }}</h2>
                    </div>
                    <div class="panel-pad">
                        <div class="row g-3">
                            @foreach ($groupSettings as $setting)
                                <div class="col-lg-6">
                                    <label class="form-label" for="setting-{{ $setting->id }}">
                                        {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        @if ($setting->is_public)
                                            <span class="badge text-bg-light ms-1">Public</span>
                                        @endif
                                    </label>

                                    @if ($setting->type === 'textarea')
                                        <textarea class="form-control" id="setting-{{ $setting->id }}" name="settings[{{ $setting->key }}]" rows="4">{{ old("settings.{$setting->key}", $setting->value) }}</textarea>
                                    @elseif ($setting->type === 'color')
                                        <div class="d-flex gap-2 align-items-center">
                                            <input class="form-control form-control-color" id="setting-{{ $setting->id }}" type="color" name="settings[{{ $setting->key }}]" value="{{ old("settings.{$setting->key}", $setting->value ?: '#111111') }}">
                                            <input class="form-control" value="{{ old("settings.{$setting->key}", $setting->value) }}" readonly>
                                        </div>
                                    @elseif ($setting->type === 'boolean')
                                        <select class="form-select" id="setting-{{ $setting->id }}" name="settings[{{ $setting->key }}]">
                                            <option value="1" @selected(old("settings.{$setting->key}", $setting->value) == '1')>Enabled</option>
                                            <option value="0" @selected(old("settings.{$setting->key}", $setting->value) == '0')>Disabled</option>
                                        </select>
                                    @else
                                        <input class="form-control" id="setting-{{ $setting->id }}" name="settings[{{ $setting->key }}]" value="{{ old("settings.{$setting->key}", $setting->value) }}">
                                    @endif

                                    <div class="form-text">{{ $setting->key }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @empty
                <div class="panel panel-pad text-muted">No settings found.</div>
            @endforelse
        </div>

        <div class="position-sticky bottom-0 bg-white border mt-4 p-3 rounded-2 d-flex justify-content-end">
            <button class="btn btn-dark" type="submit">Save Settings</button>
        </div>
    </form>
@endsection
