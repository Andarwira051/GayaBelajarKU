@extends('layouts.app')

@section('title', 'Kelola Soal')

@section('content')
<div class="bg-white p-6 rounded-xl md:ml-64 shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-3 space-y-4 md:space-y-0">
        <h1 class="text-2xl md:text-xl font-bold text-blue-500 flex items-center">
            Kelola Soal
        </h1>
        <div class="flex flex-wrap gap-2">
            <button type="button" onclick="openAddModal()" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i> Tambah Soal
            </button>
            <button type="button" onclick="openImportModal()" class="flex items-center bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition-all duration-300 transform hover:scale-105">
                <i data-lucide="file-text" class="w-5 h-5 mr-2"></i> Import Soal
            </button>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row gap-4">
        <div class="relative flex-grow">
            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" placeholder="Cari soal..." class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex gap-2">
            <select class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Semua Tipe</option>
                <option>Pilihan Ganda</option>
                <option>Essay</option>
            </select>
            <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200 transition">
                <i data-lucide="filter" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($questions as $question)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="p-4 text-sm text-gray-800 max-w-xs truncate">{{ $question->question_text }}</td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $question->type == 'multiple_choice' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($question->type) }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $question->is_favoritable ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $question->is_favoritable ? 'Favorable' : 'Unfavorable' }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <button type="button" onclick="openEditModal({{ $question->id }})" class="text-blue-600 hover:text-blue-900 flex items-center bg-blue-50 p-1.5 px-3 rounded-lg hover:bg-blue-100">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button type="button" onclick="confirmDelete({{ $question->id }})" class="delete-btn text-red-600 hover:text-red-900 flex items-center bg-red-50 p-1.5 px-3 rounded-lg hover:bg-red-100">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
            {{ $questions->links() }}
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Tambah Soal Baru</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-6">
            <form action="{{ route('questions.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teks Pertanyaan</label>
                        <textarea name="question_text" rows="4" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-3" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Soal</label>
                            <select id="edit_type" name="type" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                <option value="visual">Visual</option>
                                <option value="auditory">Auditory</option>
                                <option value="kinesthetic">Kinesthetic</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="is_favoritable" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                <option value="1">Favorable</option>
                                <option value="0">Unfavorable</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Edit Soal</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teks Pertanyaan</label>
                        <textarea id="edit_question_text" name="question_text" rows="4" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-3" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Soal</label>
                            <select id="edit_type" name="type" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                <option value="visual">Visual</option>
                                <option value="auditory">Auditory</option>
                                <option value="kinesthetic">Kinesthetic</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="edit_is_favoritable" name="is_favoritable" class="w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                <option value="1">Favorable</option>
                                <option value="0">Unfavorable</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Perbarui Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Question Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-xl w-full mx-4">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Import Soal dari Excel</h3>
            <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-6">
            <form action="{{ route('questions.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <i data-lucide="upload-cloud" class="w-12 h-12 mx-auto text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600 mb-2">Seret file Excel atau klik untuk memilih</p>
                        <input type="file" name="excel_file" class="w-full opacity-0 absolute inset-0 cursor-pointer" required>
                        <button type="button" class="py-2 px-4 bg-gray-100 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-200">
                            Pilih File
                        </button>
                        <p class="text-xs text-gray-500 mt-2">Format yang didukung: .xlsx, .xls</p>
                    </div>
                    <div class="pt-2">
                        <a href="#" class="text-blue-600 text-sm hover:underline flex items-center">
                            <i data-lucide="download" class="w-4 h-4 mr-1"></i> Unduh template
                        </a>
                    </div>
                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeImportModal()" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Import Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Yakin ingin menghapus?</h3>
            <p class="text-gray-600 mb-6">Data soal ini akan dihapus secara permanen!</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Ya, Hapus!
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });

    // Add Modal Functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Edit Modal Functions
    function openEditModal(id) {
        fetch(`/admin/questions/${id}/edit`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_question_text').value = data.question_text || '';
                document.getElementById('edit_type').value = data.type || 'visual';
                document.getElementById('edit_is_favoritable').value = data.is_favoritable ? '1' : '0';
                document.getElementById('editForm').action = `/admin/questions/${id}`;
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            })
            .catch(error => {
                console.error('Error fetching question data:', error);
                alert('Gagal memuat data soal. Silakan coba lagi.');
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Import Modal Functions
    function openImportModal() {
        document.getElementById('importModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Delete Modal Functions
    function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/admin/questions/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modals when clicking outside
    document.querySelectorAll('#addModal, #editModal, #importModal, #deleteModal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('#addModal, #editModal, #importModal, #deleteModal').forEach(modal => {
                modal.classList.add('hidden');
            });
            document.body.style.overflow = 'auto';
        }
    });
</script>
@endsection
