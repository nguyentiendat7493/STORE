@extends('layouts.app')

@section('title', 'Hồ sơ')

@section('content')
    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Account</div>
        <h1 class="section-title mb-4">Hồ sơ cá nhân</h1>
        <div class="row g-4">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="h5 mb-3">Thông tin</h2>
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
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" name="address" rows="4">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Cập nhật</button>
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
                    <button class="btn btn-outline-dark" type="submit">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
