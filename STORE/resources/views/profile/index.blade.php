@extends('layouts.app')

@section('title', 'Hồ sơ')

@section('content')
    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Tài khoản</div>
        <h1 class="section-title mb-4">Hồ sơ cá nhân</h1>
        <div class="row g-4">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="h5 mb-3">Thông tin cá nhân</h2>
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ chính</label>
                        <textarea class="form-control" name="address" rows="4">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Cập nhật hồ sơ</button>
                </form>
            </div>
            <div class="col-lg-5">
                <form class="sidebar-box" method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="h5 mb-3">Đổi mật khẩu</h2>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input class="form-control" type="password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhập lại mật khẩu mới</label>
                        <input class="form-control" type="password" name="password_confirmation" required>
                    </div>
                    <button class="btn btn-outline-dark" type="submit">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-lg-7">
                <div class="sidebar-box">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 mb-0">Địa chỉ đã lưu</h2>
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
                                        <span class="badge text-bg-dark ms-2">Mặc định</span>
                                    @endif
                                    <div class="small text-muted">{{ $address->full_address }}</div>
                                </div>
                                <div class="d-flex gap-2">
                                    @unless ($address->is_default)
                                        <button class="btn btn-sm btn-outline-dark" form="default-address-{{ $address->id }}" type="submit">Đặt mặc định</button>
                                    @endunless
                                    <button class="btn btn-sm btn-outline-danger" form="delete-address-{{ $address->id }}" type="submit">Xóa</button>
                                </div>
                            </div>
                            @include('profile.partials.address-form', ['address' => $address])
                            <button class="btn btn-outline-dark mt-3" type="submit">Lưu địa chỉ</button>
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
                        <div class="empty-state">Bạn chưa lưu địa chỉ nào.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <form class="sidebar-box" method="POST" action="{{ route('profile.addresses.store') }}">
                    @csrf
                    <h2 class="h5 mb-3">Thêm địa chỉ mới</h2>
                    @include('profile.partials.address-form', ['address' => null])
                    <button class="btn btn-primary w-100 mt-3" type="submit">Thêm địa chỉ</button>
                </form>
            </div>
        </div>
    </div>
@endsection
