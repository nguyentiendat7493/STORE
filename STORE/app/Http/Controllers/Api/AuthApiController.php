<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponds;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthApiController extends Controller
{
    use ApiResponds;

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data + ['role' => 'customer']);
        Auth::login($user);
        $request->session()->regenerate();

        return $this->success(['user' => $user], 'Đăng ký thành công.', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

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
