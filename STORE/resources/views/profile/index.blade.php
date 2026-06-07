@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Account</div>
        <h1 class="section-title mb-4">Profile</h1>
        <div class="row g-4">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="h5 mb-3">Profile Information</h2>
                    <div class="mb-3">
                        <label class="form-label">Full name</label>
                        <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Legacy address</label>
                        <textarea class="form-control" name="address" rows="4">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Update Profile</button>
                </form>
            </div>
            <div class="col-lg-5">
                <form class="sidebar-box" method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="h5 mb-3">Change Password</h2>
                    <div class="mb-3">
                        <label class="form-label">Current password</label>
                        <input class="form-control" type="password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New password</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm new password</label>
                        <input class="form-control" type="password" name="password_confirmation" required>
                    </div>
                    <button class="btn btn-outline-dark" type="submit">Update Password</button>
                </form>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-lg-7">
                <div class="sidebar-box">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 mb-0">Saved Addresses</h2>
                        <span class="badge badge-luxury">{{ $addresses->count() }}</span>
                    </div>

                    @forelse ($addresses as $address)
                        <form class="border-top py-3" method="POST" action="{{ route('profile.addresses.update', $address) }}">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <strong>{{ $address->label }}</strong>
                                    @if ($address->is_default)
                                        <span class="badge text-bg-dark ms-2">Default</span>
                                    @endif
                                    <div class="small text-muted">{{ $address->full_address }}</div>
                                </div>
                                <div class="d-flex gap-2">
                                    @unless ($address->is_default)
                                        <button class="btn btn-sm btn-outline-dark" form="default-address-{{ $address->id }}" type="submit">Default</button>
                                    @endunless
                                    <button class="btn btn-sm btn-outline-danger" form="delete-address-{{ $address->id }}" type="submit">Delete</button>
                                </div>
                            </div>
                            @include('profile.partials.address-form', ['address' => $address])
                            <button class="btn btn-outline-dark mt-3" type="submit">Save Address</button>
                        </form>
                        <form id="default-address-{{ $address->id }}" method="POST" action="{{ route('profile.addresses.default', $address) }}">
                            @csrf
                            @method('PATCH')
                        </form>
                        <form id="delete-address-{{ $address->id }}" method="POST" action="{{ route('profile.addresses.destroy', $address) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    @empty
                        <div class="empty-state">No saved addresses yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <form class="sidebar-box" method="POST" action="{{ route('profile.addresses.store') }}">
                    @csrf
                    <h2 class="h5 mb-3">New Address</h2>
                    @include('profile.partials.address-form', ['address' => null])
                    <button class="btn btn-primary w-100 mt-3" type="submit">Add Address</button>
                </form>
            </div>
        </div>
    </div>
@endsection
