// Ambil semua tes yang unik per siswa untuk keperluan statistik
$allTests = Test::whereHas('user.kelas', function ($q) use ($kelasId) {
    $q->where('kelas_id', $kelasId);
})->with('user')->get()->unique('user_id');

// Inisialisasi counter
$totalTests = $allTests->count();
$visualCount = 0;
$auditoryCount = 0;
$kinestheticCount = 0;
$visualAuditoryCount = 0;
$auditoryKinestheticCount = 0;
$visualKinestheticCount = 0;
$visualAuditoryKinestheticCount = 0;

// Hitung jumlah setiap tipe gaya belajar berdasarkan prediksi
foreach ($allTests as $test) {
    $prediction = strtolower(trim($test->prediction));

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

// Hitung persentase tiap gaya belajar
$visualPercent = $totalTests > 0 ? round(($visualCount / $totalTests) * 100) : 0;
$auditoryPercent = $totalTests > 0 ? round(($auditoryCount / $totalTests) * 100) : 0;
$kinestheticPercent = $totalTests > 0 ? round(($kinestheticCount / $totalTests) * 100) : 0;
$visualAuditoryPercent = $totalTests > 0 ? round(($visualAuditoryCount / $totalTests) * 100) : 0;
$auditoryKinestheticPercent = $totalTests > 0 ? round(($auditoryKinestheticCount / $totalTests) * 100) : 0;
$visualKinestheticPercent = $totalTests > 0 ? round(($visualKinestheticCount / $totalTests) * 100) : 0;
$visualAuditoryKinestheticPercent = $totalTests > 0 ? round(($visualAuditoryKinestheticCount / $totalTests) * 100) : 0;
