@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="bg-white p-6 rounded-xl md:ml-64 shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-3 space-y-4 md:space-y-0">
        <h1 class="text-xl md:text-xl font-bold text-blue-500 flex items-center">
            Kelola Pengguna
        </h1>
        <button id="openAddUserModal" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
            <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i> Tambah Pengguna
        </button>
    </div>

    <!-- Stats Summary -->


    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row gap-4">
        <div class="relative flex-grow">
            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" placeholder="Cari pengguna..." class="pl-10 pr-4 py-2 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex gap-2">
            <select class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Semua Role</option>
                <option>Admin</option>
                <option>Pengajar</option>
                <option>User</option>
            </select>
            <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200 transition">
                <i data-lucide="filter" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full hidden md:table">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button type="button" class="text-blue-600 hover:text-blue-900 flex items-center bg-blue-50 p-1 rounded-lg hover:bg-blue-100 edit-btn" 
                                        data-id="{{ $user->id }}" 
                                        data-name="{{ $user->name }}" 
                                        data-email="{{ $user->email }}" 
                                        data-role="{{ $user->role }}">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button type="button" class="text-red-600 hover:text-red-900 flex items-center bg-red-50 p-1 rounded-lg hover:bg-red-100 delete-btn" data-id="{{ $user->id }}">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Versi Mobile -->
            <div class="md:hidden space-y-4 p-4">
                @foreach ($users as $user)
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="flex justify-end space-x-2 pt-2 border-t border-gray-100 mt-2">
                            <button type="button" class="text-blue-600 hover:text-blue-900 flex items-center px-3 py-1 bg-blue-50 rounded-lg hover:bg-blue-100 edit-btn"
                                data-id="{{ $user->id }}" 
                                data-name="{{ $user->name }}" 
                                data-email="{{ $user->email }}" 
                                data-role="{{ $user->role }}">
                                <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                            </button>
                            <button type="button" class="text-red-600 hover:text-red-900 flex items-center px-3 py-1 bg-red-50 rounded-lg hover:bg-red-100 delete-btn" data-id="{{ $user->id }}">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                            </button>
                            <form id="delete-form-mobile-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan 1-{{ count($users) }} dari {{ count($users) }} item
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 rounded bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-50" disabled>
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="px-3 py-1 rounded bg-blue-600 text-white">1</button>
                <button class="px-3 py-1 rounded bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 disabled:opacity-50" disabled>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="addUserModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 md:mx-0 transform transition-all">
        <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Tambah Pengguna Baru</h3>
            <button id="closeAddUserModal" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="{{ route('users.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="pengajar">Pengajar</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancelAddUser" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div id="editUserModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 md:mx-0 transform transition-all">
        <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Edit Pengguna</h3>
            <button id="closeEditUserModal" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="editUserForm" action="" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="edit_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="edit_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="edit_role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="pengajar">Pengajar</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancelEditUser" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
        
        // Add Modal functionality
        const addModal = document.getElementById('addUserModal');
        const openAddModalBtn = document.getElementById('openAddUserModal');
        const closeAddModalBtn = document.getElementById('closeAddUserModal');
        const cancelAddBtn = document.getElementById('cancelAddUser');
        
        openAddModalBtn.addEventListener('click', function() {
            addModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
        
        const closeAddModal = function() {
            addModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        };
        
        closeAddModalBtn.addEventListener('click', closeAddModal);
        cancelAddBtn.addEventListener('click', closeAddModal);
        
        // Close modal when clicking outside
        addModal.addEventListener('click', function(e) {
            if (e.target === addModal) {
                closeAddModal();
            }
        });
        
        // Edit Modal functionality
        const editModal = document.getElementById('editUserModal');
        const closeEditModalBtn = document.getElementById('closeEditUserModal');
        const cancelEditBtn = document.getElementById('cancelEditUser');
        const editForm = document.getElementById('editUserForm');
        
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function() {
                const userId = this.getAttribute("data-id");
                const userName = this.getAttribute("data-name");
                const userEmail = this.getAttribute("data-email");
                const userRole = this.getAttribute("data-role");
                
                // Set form action
                editForm.action = `/users/${userId}`;
                
                // Fill form fields
                document.getElementById('edit_name').value = userName;
                document.getElementById('edit_email').value = userEmail;
                document.getElementById('edit_role').value = userRole;
                
                // Clear password fields
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';
                
                // Show modal
                editModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });
        
        const closeEditModal = function() {
            editModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };
        
        closeEditModalBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);
        
        // Close modal when clicking outside
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) {
                closeEditModal();
            }
        });
        
        // Delete user functionality
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let userId = this.getAttribute("data-id");
                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Data pengguna ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${userId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection