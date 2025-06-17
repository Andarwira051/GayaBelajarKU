<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Test;

class KelasController extends Controller
{

    public function show($id, Request $request)
    {
        // $id adalah ID kelas yang sedang dilihat
        $kelas = Kelas::with('users.tests')->find($id);

        // Pastikan kelas milik pengajar yang login
        if ($kelas->pengajar_id !== auth()->id()) {
            abort(403, 'Kelas tidak ditemukan atau bukan milik Anda.');
        }

        // Ambil semua kelas yang diajar oleh pengajar untuk dropdown
        $daftarKelas = Kelas::where('pengajar_id', auth()->id())->get();

        // Logic untuk menentukan kelas mana yang akan ditampilkan statistiknya
        $kelasId = $request->kelas_id ?? $id; // Jika tidak ada filter kelas_id, gunakan kelas yang sedang dilihat

        // Pastikan kelas yang dipilih milik pengajar ini
        $kelasIds = $daftarKelas->pluck('id')->toArray();
        if (!in_array($kelasId, $kelasIds)) {
            $kelasId = $id; // Fallback ke kelas yang sedang dilihat
        }

        // Query untuk tests dengan filter
        $query = Test::with('user');

        // Filter berdasarkan kelas yang dipilih
        $query->whereHas('user.kelas', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        });

        // Filter berdasarkan nama pengguna
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Filter berdasarkan gaya belajar
        if ($request->filled('gaya_belajar')) {
            $query->where('prediction', $request->gaya_belajar);
        }

        // Ambil tests unik per user untuk display
        $testsCollection = $query->latest()->get()->unique('user_id');

        // Convert ke paginated result
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $tests = new \Illuminate\Pagination\LengthAwarePaginator(
            $testsCollection->forPage($currentPage, $perPage),
            $testsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );

        // Ambil semua tests untuk statistik (tanpa filter nama/gaya belajar)
        $allTests = Test::whereHas('user.kelas', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        })
        ->with('user')
        ->get()
        ->unique('user_id'); // Unik berdasarkan user_id

        // Inisialisasi counter untuk statistik
        $totalTests = $allTests->count();
        $visualCount = 0;
        $auditoryCount = 0;
        $kinestheticCount = 0;
        $visualAuditoryCount = 0;
        $auditoryKinestheticCount = 0;
        $visualKinestheticCount = 0;
        $visualAuditoryKinestheticCount = 0;

        // Hitung statistik berdasarkan prediksi (setiap siswa hanya dihitung sekali)
        foreach ($allTests as $test) {
            $prediction = strtolower(trim($test->prediction));

            // Setiap prediksi hanya masuk ke SATU kategori
            if (strpos($prediction, 'visual') !== false &&
                strpos($prediction, 'auditorial') !== false &&
                strpos($prediction, 'kinestetik') !== false) {
                $visualAuditoryKinestheticCount++;
            } elseif (strpos($prediction, 'visual') !== false && strpos($prediction, 'auditorial') !== false) {
                $visualAuditoryCount++;
            } elseif (strpos($prediction, 'auditorial') !== false && strpos($prediction, 'kinestetik') !== false) {
                $auditoryKinestheticCount++;
            } elseif (strpos($prediction, 'visual') !== false && strpos($prediction, 'kinestetik') !== false) {
                $visualKinestheticCount++;
            } elseif (strpos($prediction, 'visual') !== false) {
                $visualCount++;
            } elseif (strpos($prediction, 'auditorial') !== false) {
                $auditoryCount++;
            } elseif (strpos($prediction, 'kinestetik') !== false) {
                $kinestheticCount++;
            }
        }

        // Hitung persentase
        $visualPercent = $totalTests > 0 ? round(($visualCount / $totalTests) * 100) : 0;
        $auditoryPercent = $totalTests > 0 ? round(($auditoryCount / $totalTests) * 100) : 0;
        $kinestheticPercent = $totalTests > 0 ? round(($kinestheticCount / $totalTests) * 100) : 0;
        $visualAuditoryPercent = $totalTests > 0 ? round(($visualAuditoryCount / $totalTests) * 100) : 0;
        $auditoryKinestheticPercent = $totalTests > 0 ? round(($auditoryKinestheticCount / $totalTests) * 100) : 0;
        $visualKinestheticPercent = $totalTests > 0 ? round(($visualKinestheticCount / $totalTests) * 100) : 0;
        $visualAuditoryKinestheticPercent = $totalTests > 0 ? round(($visualAuditoryKinestheticCount / $totalTests) * 100) : 0;

        return view('pengajar.kelas.show', compact(
            'kelas',
            'tests',
            'daftarKelas',
            'totalTests',
            'visualCount',
            'auditoryCount',
            'kinestheticCount',
            'visualPercent',
            'auditoryPercent',
            'kinestheticPercent',
            'visualAuditoryPercent',
            'auditoryKinestheticPercent',
            'visualKinestheticPercent',
            'visualAuditoryCount',
            'auditoryKinestheticCount',
            'visualKinestheticCount',
            'visualAuditoryKinestheticCount',
            'visualAuditoryKinestheticPercent'
        ));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('pengajar.kelas.edit', compact('kelas'));
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->users()->detach(); // Jika ada relasi dengan siswa
        $kelas->delete();

        return redirect()->route('pengajar.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->save();

        return redirect()->route('pengajar.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
}
