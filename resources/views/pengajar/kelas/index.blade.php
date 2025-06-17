@extends('layouts.nav')

@section('title', 'Kelola Kelas')

@section('content')
    <div class="bg-white p-6 rounded-xl md:ml-64 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <h1 class="text-xl md:text-2xl font-bold text-blue-500 flex items-center">
                <i data-lucide="users" class="w-6 h-6 mr-2"></i>
                Kelola Kelas
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('pengajar.kelas.create') }}"
                    class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                    <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                    Tambah Kelas
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row gap-4">
            <form method="GET" action="{{ route('pengajar.kelas.index') }}"
                class="relative flex-grow flex flex-col md:flex-row gap-4 w-full">
                <div class="relative flex-grow">
                    <i data-lucide="search"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama kelas atau token..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>
        </div>


        <!-- Daftar Kelas -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            @if (isset($kelas) && $kelas->count() > 0)
                <!-- Desktop View -->
                <div class="overflow-x-auto">
                    <table class="w-full hidden md:table">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                    Kelas</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token
                                    Kelas</th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah Peserta Tes</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat
                                </th>
                                <th class="p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($kelas as $index => $kelasItem)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="p-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="">
                                                <p class="text-sm font-medium text-gray-900">{{ $kelasItem->nama_kelas }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="px-3 py-1 text-sm font-mono bg-gray-100 text-gray-800 rounded-lg border">
                                                {{ $kelasItem->token_kelas }}
                                            </span>
                                            <button onclick="copyToken('{{ $kelasItem->token_kelas }}')"
                                                class="text-gray-400 hover:text-blue-600 transition" title="Salin Token">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                            {{ $kelasItem->users->count() }} Peserta Tes
                                        </span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $kelasItem->created_at->format('d M Y') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('pengajar.kelas.show', $kelasItem->id) }}"
                                                class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <button
                                                onclick="openEditModal({{ $kelasItem->id }}, '{{ $kelasItem->nama_kelas }}')"
                                                class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </button>
                                            <button onclick="deleteKelas({{ $kelasItem->id }})"
                                                class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $kelasItem->id }}"
                                            action="{{ route('pengajar.kelas.destroy', $kelasItem->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="md:hidden space-y-4 p-4">
                    @foreach ($kelas as $kelasItem)
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                        {{ substr($kelasItem->nama_kelas, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $kelasItem->nama_kelas }}</p>
                                        <p class="text-xs text-gray-500">{{ $kelasItem->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                    {{ $kelasItem->users->count() }} Peserta Tes
                                </span>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg mb-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Token Kelas:</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-mono bg-white px-2 py-1 rounded border">
                                            {{ $kelasItem->token_kelas }}
                                        </span>
                                        <button onclick="copyToken('{{ $kelasItem->token_kelas }}')"
                                            class="text-gray-400 hover:text-blue-600 transition">
                                            <i data-lucide="copy" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('pengajar.kelas.show', $kelasItem->id) }}"
                                    class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <button onclick="openEditModal({{ $kelasItem->id }}, '{{ $kelasItem->nama_kelas }}')"
                                    class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button onclick="deleteKelas({{ $kelasItem->id }})"
                                    class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $kelasItem->id }}"
                                action="{{ route('pengajar.kelas.destroy', $kelasItem->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if (method_exists($kelas, 'links'))
                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $kelas->firstItem() ?? '0' }}-{{ $kelas->lastItem() ?? '0' }} dari
                            {{ $kelas->total() }} kelas
                        </div>
                        <div>
                            {{ $kelas->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="book-open" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kelas</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan membuat kelas pertama Anda</p>
                    <a href="{{ route('pengajar.kelas.create') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all duration-300">
                        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                        Buat Kelas Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Edit Kelas -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit Kelas
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kelas
                        </label>
                        <input type="text" id="nama_kelas" name="nama_kelas" value=""
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast untuk copy token -->
    <div id="toast"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center">
            <i data-lucide="check" class="w-4 h-4 mr-2"></i>
            <span>Token berhasil disalin!</span>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });

        // Function untuk copy token
        function copyToken(token) {
            navigator.clipboard.writeText(token).then(function() {
                showToast();
            }).catch(function(err) {
                console.error('Gagal menyalin token: ', err);
            });
        }

        // Function untuk show toast
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-x-full');
            setTimeout(() => {
                toast.classList.add('translate-x-full');
            }, 2000);
        }

        // Function untuk delete kelas
        function deleteKelas(kelasId) {
            Swal.fire({
                title: "Yakin ingin menghapus kelas?",
                text: "Semua data siswa dalam kelas ini akan ikut terhapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${kelasId}`).submit();
                }
            });
        }

        // Function untuk buka edit modal
        function openEditModal(kelasId, namaKelas) {
            // Gunakan Laravel route helper
            const updateUrl = "{{ route('pengajar.kelas.update', ':id') }}".replace(':id', kelasId);
            document.getElementById('editForm').action = updateUrl;

            // Set nilai nama kelas
            document.getElementById('nama_kelas').value = namaKelas;

            // Tampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Function untuk tutup edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('editModal').classList.contains('hidden')) {
                closeEditModal();
            }
        });
    </script>
@endsection
