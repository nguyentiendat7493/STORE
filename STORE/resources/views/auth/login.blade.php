@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h1 class="h3 mb-4">Đăng nhập</h1>
                <form class="sidebar-box" method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                    <div class="mt-3 small">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></div>
                </form>
            </div>
        </div>
    </div>
@endsection
