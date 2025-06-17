<div>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-5 text-gray-800 dark:text-white">Edit Outlet: {{ $outlet->name }}</h1>
            
            <form action="{{ route('outlet.update', $outlet->id) }}" method="POST" class="ajax-form space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Outlet <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $outlet->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Telepon (Opsional)</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $outlet->phone) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                
                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat (Opsional)</label>
                    <textarea id="address" name="address" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('address', $outlet->address) }}</textarea>
                </div>
                
                <div class="flex justify-end pt-4 space-x-2">
                    <a href="{{ route('outlet.index') }}" class="menu-link px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>