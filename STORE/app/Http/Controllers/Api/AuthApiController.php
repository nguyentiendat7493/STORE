<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    use ApiResponds;

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data + ['role' => 'customer']);
        Auth::login($user);
        $request->session()->regenerate();

        return $this->success(['user' => $user], 'Đăng ký thành công.', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return $this->error('Email hoặc mật khẩu không đúng.', 422);
        }

        $request->session()->regenerate();

        return $this->success(['user' => $request->user()], 'Đăng nhập thành công.');
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->success(null, 'Đã đăng xuất.');
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success(['user' => $request->user()]);
    }
}
