<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $tests = Test::where('user_id', $userId)
                    ->with('user') // Load user relationship
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Jika tidak ada kelas_id di tabel tests, kita ambil kelas berdasarkan user
        foreach ($tests as $test) {
            // Ambil kelas yang diikuti user saat ini (asumsi user hanya di 1 kelas aktif)
            $userKelas = Kelas::whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('pengajar') // Load pengajar relationship
            ->first();

            // Assign kelas ke test object
            $test->kelas_info = $userKelas;
        }

        return view('riwayat', compact('tests'));
    }

    public function showDetail($id)
    {
        $userId = Auth::id();

        // Ambil test berdasarkan ID dan pastikan milik user yang sedang login
        $test = Test::where('id', $id)
                   ->where('user_id', $userId)
                   ->first();

        if (!$test) {
            return redirect()->route('riwayat')->with('error', 'Hasil tes tidak ditemukan.');
        }

        // Hitung persentase untuk setiap gaya belajar
        $total = $test->visual_score + $test->auditory_score + $test->kinesthetic_score;

        if ($total > 0) {
            $visualPercentage = round(($test->visual_score / $total) * 100);
            $auditoryPercentage = round(($test->auditory_score / $total) * 100);
            $kinestheticPercentage = round(($test->kinesthetic_score / $total) * 100);
        } else {
            $visualPercentage = 0;
            $auditoryPercentage = 0;
            $kinestheticPercentage = 0;
        }

       return view('riwayat-detail', compact(
            'test',
            'visualPercentage',
            'auditoryPercentage',
            'kinestheticPercentage'
       ));
    }
}
