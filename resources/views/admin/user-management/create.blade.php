<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-5">Tambah User Baru</h1>
            <form action="{{ route('admin.user-management.store') }}" method="POST" class="ajax-form space-y-6">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           required placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           required placeholder="contoh@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="role_id" class="block mb-2 text-sm font-medium">Role</label>
                    <select id="role_id" name="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="outlet_id" class="block mb-2 text-sm font-medium">Outlet</label>
                    <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">-- Pilih Outlet --</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('outlet_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="position" class="block mb-2 text-sm font-medium">Posisi/Jabatan (Opsional)</label>
                    <input type="text" id="position" name="position" value="{{ old('position') }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           placeholder="Contoh: Manager, Kasir, Staff">
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" value="12345" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           required placeholder="Minimal 4 karakter">
                    <p class="mt-1 text-sm text-gray-500">Default password: 12345 (dapat diubah)</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-400">
                                Informasi
                            </h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <p>User baru akan ditambahkan ke lembaga: <strong>{{ $lembaga->name ?? 'Tidak diketahui' }}</strong></p>
                                <p>User dapat login menggunakan email dan password yang telah ditentukan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.user-management.index') }}" 
                       class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-6 py-3">
                        Batal
                    </a>
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-6 py-3">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>