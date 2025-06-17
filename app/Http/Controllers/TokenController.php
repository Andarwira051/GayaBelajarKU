<?php

namespace App\Http\Controllers;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function showForm()
    {
        return view('token-input');
    }

    public function submitToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = $request->input('token');

        // Cari kelas berdasarkan token_kelas
        $kelas = Kelas::where('token_kelas', $token)->first();

        if ($kelas) {
            $user = Auth::user();

            // Ambil nama pengajar dari relasi
            $pengajar = $kelas->pengajar;

            // Cek apakah user sudah tergabung ke kelas ini
            $sudahGabung = $kelas->users()->where('user_id', $user->id)->exists();

            if (!$sudahGabung) {
                // Tambahkan user ke kelas
                $kelas->users()->attach($user->id);
            }

            // Simpan data kelas dan nama pengajar di session
            session([
                'kelas_id' => $kelas->id,
                'kelas_token' => $token,
                'nama_kelas' => $kelas->nama_kelas, // Tambahkan nama kelas ke session
                'nama_pengajar' => $pengajar ? $pengajar->name : 'Tidak ada pengajar',
                'token_valid' => true,
            ]);

            return redirect()->back()->with('success', 'Token valid! Selamat datang di kelas ' . $kelas->nama_kelas . ' dengan pengajar ' . ($pengajar ? $pengajar->name : 'Tidak ada pengajar') . '.');
        } else {
            session(['token_valid' => false]);
            return redirect()->back()->withErrors(['token' => 'Kode kelas tidak valid.'])->withInput();
        }
    }

    public function clearToken()
    {
        // Hapus semua session yang terkait dengan token
        session()->forget([
            'kelas_id',
            'kelas_token',
            'nama_kelas',
            'nama_pengajar',
            'token_valid'
        ]);

        return redirect()->route('token.form');
    }

    public function protectQuiz()
    {
        if (!session('token_valid')) {
            return redirect()->route('token.form')->withErrors(['token' => 'Silakan masukkan kode kelas yang valid terlebih dahulu.']);
        }
        return true;
    }
}
