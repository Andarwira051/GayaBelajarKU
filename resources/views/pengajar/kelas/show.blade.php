@extends('layouts.nav')
@section('title', 'Detail Kelas')

@section('content')
    <div class="bg-white p-6 rounded-xl md:ml-64 shadow-lg">
        <!-- Header Kelas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $kelas->nama_kelas }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Token Kelas</h3>
                    <p class="text-xl font-mono text-blue-600">{{ $kelas->token_kelas }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800">Jumlah Peserta Tes</h3>
                    <p class="text-xl font-bold text-green-600">{{ $kelas->users->count() }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-800">Jumlah Yang Sudah Tes</h3>
                    <p class="text-xl font-bold text-purple-600">
                        {{ $kelas->users->filter(function ($user) {return $user->tests->count() > 0;})->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik Global Gaya Belajar -->
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistik Gaya Belajar</h2>

            <!-- Gaya Belajar Individual -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Visual -->
                <div class="bg-blue-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <i data-lucide="eye" class="w-6 h-6 text-blue-600"></i>
                            </div>
                            <h3 class="ml-3 font-medium text-blue-800">Visual</h3>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $visualPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $visualPercent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $visualCount }} dari {{ $totalTests }} Peserta Tes</p>
                </div>

                <!-- Auditory -->
                <div class="bg-purple-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <i data-lucide="volume-2" class="w-6 h-6 text-purple-600"></i>
                            </div>
                            <h3 class="ml-3 font-medium text-purple-800">Auditorial</h3>
                        </div>
                        <span class="text-2xl font-bold text-purple-600">{{ $auditoryPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $auditoryPercent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $auditoryCount }} dari {{ $totalTests }} Peserta Tes</p>
                </div>

                <!-- Kinesthetic -->
                <div class="bg-green-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <i data-lucide="move" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <h3 class="ml-3 font-medium text-green-800">Kinestetik</h3>
                        </div>
                        <span class="text-2xl font-bold text-green-600">{{ $kinestheticPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $kinestheticPercent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $kinestheticCount }} dari {{ $totalTests }} Peserta Tes</p>
                </div>
            </div>

            <!-- Gaya Belajar Kombinasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Visual dan Auditory -->
                <div class="bg-indigo-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <i data-lucide="eye" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <h3 class="ml-2 font-medium text-indigo-800 text-sm">Visual + Auditorial</h3>
                        </div>
                        <span class="text-lg font-bold text-indigo-600">{{ $visualAuditoryPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $visualAuditoryPercent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">{{ $visualAuditoryCount }} dari {{ $totalTests }} Peserta Tes</p>
                </div>

                <!-- Auditory dan Kinesthetic -->
                <div class="bg-teal-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-teal-100 p-2 rounded-lg">
                                <i data-lucide="volume-2" class="w-5 h-5 text-teal-600"></i>
                            </div>
                            <h3 class="ml-2 font-medium text-teal-800 text-sm">Auditorial + Kinestetik</h3>
                        </div>
                        <span class="text-lg font-bold text-teal-600">{{ $auditoryKinestheticPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $auditoryKinestheticPercent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">{{ $auditoryKinestheticCount }} dari {{ $totalTests }}
                        Peserta Tes</p>
                </div>

                <!-- Visual dan Kinesthetic -->
                <div class="bg-orange-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-orange-100 p-2 rounded-lg">
                                <i data-lucide="eye" class="w-5 h-5 text-orange-600"></i>
                            </div>
                            <h3 class="ml-2 font-medium text-orange-800 text-sm">Visual + Kinestetik</h3>
                        </div>
                        <span class="text-lg font-bold text-orange-600">{{ $visualKinestheticPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $visualKinestheticPercent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">{{ $visualKinestheticCount }} dari {{ $totalTests }} Peserta Tes
                    </p>
                </div>

                <!-- Visual, Auditory dan Kinesthetic -->
                <div class="bg-pink-50 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="bg-pink-100 p-2 rounded-lg">
                                <i data-lucide="zap" class="w-5 h-5 text-pink-600"></i>
                            </div>
                            <h3 class="ml-2 font-medium text-pink-800 text-sm">Visual + Auditorial + Kinestetik</h3>
                        </div>
                        <span class="text-lg font-bold text-pink-600">{{ $visualAuditoryKinestheticPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-pink-600 h-2 rounded-full" style="width: {{ $visualAuditoryKinestheticPercent }}%">
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">{{ $visualAuditoryKinestheticCount }} dari {{ $totalTests }}
                        Peserta Tes</p>
                </div>
            </div>
        </div>

        <!-- Hasil Test Siswa -->
        <div class="bg-white rounded-xl shadow-md p-6 ">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Hasil Gaya Belajar</h2>

            @if ($kelas->users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full hidden md:table">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                    Peserta Tes</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Tes</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Visual</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Auditori</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kinestetik</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rata-rata</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hasil Gaya Belajar</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Tes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($kelas->users as $user)
                                @php
                                    $test = $user->tests->last();
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ $user->name }}</td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                Belum Tes
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            <span class="text-sm font-medium text-blue-600">{{ $test->visual_score }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            <span class="text-sm font-medium text-green-600">{{ $test->auditory_score }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            <span
                                                class="text-sm font-medium text-purple-600">{{ $test->kinesthetic_score }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            <span
                                                class="text-sm font-medium text-gray-800">{{ number_format($test->average_score, 1) }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        @if ($test)
                                            @php
                                                $prediction = strtolower($test->prediction);
                                                $badgeColor = 'bg-gray-100 text-gray-800';

                                                if (
                                                    strpos($prediction, 'visual') !== false &&
                                                    strpos($prediction, 'auditorial') !== false &&
                                                    strpos($prediction, 'kinestetik') !== false
                                                ) {
                                                    $badgeColor = 'bg-pink-100 text-pink-800';
                                                } elseif (
                                                    strpos($prediction, 'visual') !== false &&
                                                    strpos($prediction, 'auditorial') !== false
                                                ) {
                                                    $badgeColor = 'bg-indigo-100 text-indigo-800';
                                                } elseif (
                                                    strpos($prediction, 'auditorial') !== false &&
                                                    strpos($prediction, 'kinestetik') !== false
                                                ) {
                                                    $badgeColor = 'bg-teal-100 text-teal-800';
                                                } elseif (
                                                    strpos($prediction, 'visual') !== false &&
                                                    strpos($prediction, 'kinestetik') !== false
                                                ) {
                                                    $badgeColor = 'bg-orange-100 text-orange-800';
                                                } elseif (strpos($prediction, 'visual') !== false) {
                                                    $badgeColor = 'bg-blue-100 text-blue-800';
                                                } elseif (strpos($prediction, 'auditorial') !== false) {
                                                    $badgeColor = 'bg-purple-100 text-purple-800';
                                                } elseif (strpos($prediction, 'kinestetik') !== false) {
                                                    $badgeColor = 'bg-green-100 text-green-800';
                                                }
                                            @endphp
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                                                {{ ucfirst($test->prediction) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        @if ($test)
                                            {{ $test->created_at->format('d M Y H:i') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-6xl mb-4">📊</div>
                    <p class="text-gray-500 text-lg">Belum ada siswa yang terdaftar</p>
                    <p class="text-gray-400 text-sm mt-2">Bagikan token kelas kepada peserta tes untuk bergabung</p>
                </div>
            @endif
        </div>
    </div>
@endsection
