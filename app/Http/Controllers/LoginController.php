<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'email.email' => 'Email tidak valid.'
        ]);

        // Check if email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.'
            ])->withInput();
        }

        // Attempt to login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        // If login fails, it means password is incorrect
        return back()->withErrors([
            'password' => 'Password salah.'
        ])->withInput();
    }

    //Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //Menangani proses registrasi pengguna
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // Mengarahkan pengguna berdasarkan role mereka
    private function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->intended('/admin');
            case 'pengajar':
                return redirect()->intended('/pengajar/kelas');
            default:
                return redirect()->intended('/');
        }
    }
}
