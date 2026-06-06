@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="eyebrow mb-2">Account</div>
                <h1 class="section-title mb-4">Đăng ký</h1>
                <form class="sidebar-box" method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input class="form-control" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nhập lại mật khẩu</label>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-4" type="submit">Tạo tài khoản</button>
                    <div class="mt-3 small">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></div>
                </form>
            </div>
        </div>
    </div>
@endsection
