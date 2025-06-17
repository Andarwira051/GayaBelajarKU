<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengajarController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Ambil semua kelas yang diajar oleh pengajar
    //     $daftarKelas = Kelas::where('pengajar_id', auth()->id())->get();
    //     $kelasIds = $daftarKelas->pluck('id')->toArray();

    //     $kelasId = $request->kelas_id;

    //     $query = Test::with('user');

    //     // Ambil semua test berdasarkan kelas
    //     if ($kelasId) {
    //         // Pastikan pengajar hanya akses kelas miliknya
    //         if (!in_array($kelasId, $kelasIds)) {
    //             abort(403, 'Kelas tidak ditemukan atau bukan milik Anda.');
    //         }

    //         $query->whereHas('user.kelas', function ($q) use ($kelasId) {
    //             $q->where('kelas_id', $kelasId);
    //         });

    //         $allTests = Test::whereHas('user.kelas', function ($q) use ($kelasId) {
    //             $q->where('kelas_id', $kelasId);
    //         })->get();
    //     } else {
    //         $query->whereHas('user.kelas', function ($q) use ($kelasIds) {
    //             $q->whereIn('kelas_id', $kelasIds);
    //         });

    //         $allTests = Test::whereHas('user.kelas', function ($q) use ($kelasIds) {
    //             $q->whereIn('kelas_id', $kelasIds);
    //         })->get();
    //     }

    //     // Filter berdasarkan nama pengguna
    //     if ($request->filled('user_name')) {
    //         $query->whereHas('user', function ($q) use ($request) {
    //             $q->where('name', 'like', '%' . $request->user_name . '%');
    //         });
    //     }

    //     // Filter berdasarkan gaya belajar
    //     if ($request->filled('gaya_belajar')) {
    //         $query->where('prediction', $request->gaya_belajar);
    //     }

    //     $tests = $query->latest()->paginate(10);

    //     // Statistik
    //     $totalTests = $allTests->count();
    //     $visualCount = 0;
    //     $auditoryCount = 0;
    //     $kinestheticCount = 0;
    //     $visualAuditoryCount = 0;
    //     $auditoryKinestheticCount = 0;
    //     $visualKinestheticCount = 0;
    //     $visualAuditoryKinestheticCount = 0;

    //     foreach ($allTests as $test) {
    //         $predictions = explode(' dan ', strtolower($test->prediction));

    //         if (in_array('visual', $predictions)) $visualCount++;
    //         if (in_array('auditorial', $predictions)) $auditoryCount++;
    //         if (in_array('kinestetik', $predictions)) $kinestheticCount++;

    //         if (in_array('visual', $predictions) && in_array('auditorial', $predictions)) $visualAuditoryCount++;
    //         if (in_array('auditorial', $predictions) && in_array('kinestetik', $predictions)) $auditoryKinestheticCount++;
    //         if (in_array('visual', $predictions) && in_array('kinestetik', $predictions)) $visualKinestheticCount++;

    //         if (
    //             in_array('visual', $predictions) &&
    //             in_array('auditorial', $predictions) &&
    //             in_array('kinestetik', $predictions)
    //         ) {
    //             $visualAuditoryKinestheticCount++;
    //         }
    //     }

    //     $visualPercent = $totalTests > 0 ? round(($visualCount / $totalTests) * 100) : 0;
    //     $auditoryPercent = $totalTests > 0 ? round(($auditoryCount / $totalTests) * 100) : 0;
    //     $kinestheticPercent = $totalTests > 0 ? round(($kinestheticCount / $totalTests) * 100) : 0;

    //     $visualAuditoryPercent = $totalTests > 0 ? round(($visualAuditoryCount / $totalTests) * 100) : 0;
    //     $auditoryKinestheticPercent = $totalTests > 0 ? round(($auditoryKinestheticCount / $totalTests) * 100) : 0;
    //     $visualKinestheticPercent = $totalTests > 0 ? round(($visualKinestheticCount / $totalTests) * 100) : 0;
    //     $visualAuditoryKinestheticPercent = $totalTests > 0 ? round(($visualAuditoryKinestheticCount / $totalTests) * 100) : 0;

    //     return view('pengajar.index', compact(
    //         'tests',
    //         'daftarKelas',
    //         'totalTests',
    //         'visualCount',
    //         'auditoryCount',
    //         'kinestheticCount',
    //         'visualPercent',
    //         'auditoryPercent',
    //         'kinestheticPercent',
    //         'visualAuditoryPercent',
    //         'auditoryKinestheticPercent',
    //         'visualKinestheticPercent',
    //         'visualAuditoryCount',
    //         'auditoryKinestheticCount',
    //         'visualKinestheticCount',
    //         'visualAuditoryKinestheticCount',
    //         'visualAuditoryKinestheticPercent'
    //     ));
    // }




    // Tampilkan form buat kelas
    public function buatKelasForm()
    {
        return view('pengajar.kelas.buat');
    }

    public function lihatKelas()
    {
        $kelas = Kelas::where('pengajar_id', auth()->id())->get();
        return view('pengajar.kelas.index', compact('kelas'));
    }



    // Proses simpan kelas baru dengan generate token
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'token_kelas' => 'KELAS-' . strtoupper(Str::random(6)), // Generate token otomatis
            'pengajar_id' => auth()->id(), // ID pengajar yang sedang login
        ]);

        return redirect()->route('pengajar.kelas.index')
                    ->with('success', 'Kelas berhasil dibuat!');
    }

    // Daftar kelas pengajar (sudah ada)
    public function daftarKelas()
    {
        $kelasSaya = Kelas::where('pengajar_id', auth()->id())->get();
        return view('pengajar.kelas.index', compact('kelasSaya'));
    }

}
