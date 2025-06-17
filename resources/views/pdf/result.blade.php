<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Gaya Belajar Peserta Tes</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }

        .info-label {
            width: 180px;
            font-weight: bold;
            display: inline-block;
        }

        .info-value {
            flex: 1;
            border-bottom: 1px solid #333;
            padding-left: 10px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            text-transform: uppercase;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .statistics-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .statistics-table th,
        .statistics-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .statistics-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        .results-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 10px;
        }

        .results-table td:first-child {
            text-align: center;
            width: 30px;
        }

        .results-table td:nth-child(2) {
            text-align: left;
            width: 120px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .status-selesai {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .status-belum {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .gaya-visual { background-color: #e3f2fd; color: #1565c0; }
        .gaya-auditori { background-color: #f3e5f5; color: #7b1fa2; }
        .gaya-kinestetik { background-color: #e8f5e8; color: #2e7d32; }
        .gaya-kombinasi { background-color: #fce4ec; color: #c2185b; }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Statistik Gaya Belajar Peserta Tes</h1>
    </div>

    <!-- Informasi Kelas -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Nama Kelas</span>
            <span class="info-value">{{ $kelas->nama_kelas }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kode Kelas</span>
            <span class="info-value">{{ $kelas->token_kelas }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Nama Pengajar</span>
            <span class="info-value">{{ $kelas->user->name ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jumlah Peserta Tes</span>
            <span class="info-value">{{ $kelas->users->count() }} orang</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jumlah Yang Sudah Tes</span>
            <span class="info-value">{{ $kelas->users->filter(function ($user) {return $user->tests->count() > 0;})->count() }} orang</span>
        </div>
    </div>

    <!-- Statistik Gaya Belajar -->
    <div class="section-title">Statistik Gaya Belajar Peserta Tes:</div>
    <table class="statistics-table">
        <thead>
            <tr>
                <th>Gaya Belajar</th>
                <th>Presentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Visual</td>
                <td>{{ $visualPercent }}%</td>
            </tr>
            <tr>
                <td>Auditori</td>
                <td>{{ $auditoryPercent }}%</td>
            </tr>
            <tr>
                <td>Kinestetik</td>
                <td>{{ $kinestheticPercent }}%</td>
            </tr>
            <tr>
                <td>Visual + Auditori</td>
                <td>{{ $visualAuditoryPercent }}%</td>
            </tr>
            <tr>
                <td>Auditori + Kinestetik</td>
                <td>{{ $auditoryKinestheticPercent }}%</td>
            </tr>
            <tr>
                <td>Visual + Kinestetik</td>
                <td>{{ $visualKinestheticPercent }}%</td>
            </tr>
            <tr>
                <td>Visual + Auditori + Kinestetik</td>
                <td>{{ $visualAuditoryKinestheticPercent }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- Hasil Gaya Belajar -->
    <div class="section-title">Hasil Gaya Belajar Peserta Tes:</div>
    <table class="results-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta Tes</th>
                <th>Status Tes</th>
                <th>Visual</th>
                <th>Auditori</th>
                <th>Kinestetik</th>
                <th>Rata-rata</th>
                <th>Hasil Gaya Belajar</th>
                <th>Tanggal Tes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas->users as $index => $user)
                @php
                    $test = $user->tests->last();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $user->name }}</td>
                    <td>
                        @if ($test)
                            <span class="badge status-selesai">Selesai</span>
                        @else
                            <span class="badge status-belum">Belum Tes</span>
                        @endif
                    </td>
                    <td>{{ $test ? $test->visual_score : '-' }}</td>
                    <td>{{ $test ? $test->auditory_score : '-' }}</td>
                    <td>{{ $test ? $test->kinesthetic_score : '-' }}</td>
                    <td>{{ $test ? number_format($test->average_score, 1) : '-' }}</td>
                    <td>
                        @if ($test)
                            @php
                                $prediction = strtolower($test->prediction);
                                $badgeClass = 'gaya-visual';

                                if (strpos($prediction, 'visual') !== false &&
                                    strpos($prediction, 'auditorial') !== false &&
                                    strpos($prediction, 'kinestetik') !== false) {
                                    $badgeClass = 'gaya-kombinasi';
                                } elseif (strpos($prediction, 'visual') !== false && strpos($prediction, 'auditorial') !== false) {
                                    $badgeClass = 'gaya-kombinasi';
                                } elseif (strpos($prediction, 'auditorial') !== false && strpos($prediction, 'kinestetik') !== false) {
                                    $badgeClass = 'gaya-kombinasi';
                                } elseif (strpos($prediction, 'visual') !== false && strpos($prediction, 'kinestetik') !== false) {
                                    $badgeClass = 'gaya-kombinasi';
                                } elseif (strpos($prediction, 'auditorial') !== false) {
                                    $badgeClass = 'gaya-auditori';
                                } elseif (strpos($prediction, 'kinestetik') !== false) {
                                    $badgeClass = 'gaya-kinestetik';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($test->prediction) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $test ? $test->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Dokumen ini diciptakan secara elektronik<br>
        berdasarkan data pada Sistem Statistik<br>
        GayaBelajarKU</strong></p>
        <p>Tanggal dokumen diciptakan: {{ date('d-m-Y') }}</p>
    </div>
</body>
</html>
