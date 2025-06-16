<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-semibold">Manajemen User & Role</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Kelola user dan role untuk {{ $lembaga->name ?? 'lembaga ini' }}.
                        </p>
                    </div>
                    <a href="{{ route('admin.user-management.create') }}"
                       class="create-link mt-4 md:mt-0 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5"
                       data-title="Tambah User Baru">
                        <i class="fas fa-plus mr-2"></i>Tambah User
                    </a>
                </div>

                <div class="overflow-x-auto relative mt-4 sm:rounded-lg">
                    <table id="data-table" class="display w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.user-management.data') }}",
            columns: [
                { data: 'name', name: 'employee.name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'roles.display_name', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[3, 'desc']],
            language: {
                processing: "Memproses...",
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                loadingRecords: "Memuat...",
                zeroRecords: "Tidak ada data yang ditemukan",
                emptyTable: "Tidak ada data tersedia",
                paginate: {
                    first: "Pertama",
                    previous: "Sebelumnya",
                    next: "Selanjutnya",
                    last: "Terakhir"
                }
            }
        });
    });

    function resetPassword(userId) {
        if (confirm('Apakah Anda yakin ingin reset password user ini ke 12345?')) {
            $.post(`/dashboard/admin/user-management/${userId}/reset-password`, {
                _token: '{{ csrf_token() }}'
            }, function (response) {
                if (response.success) {
                    alert(response.message);
                } else {
                    alert('Terjadi kesalahan: ' + response.message);
                }
            }).fail(function () {
                alert('Terjadi kesalahan saat reset password');
            });
        }
    }

    function deleteUser(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini dari lembaga?')) {
            $.ajax({
                url: `/dashboard/admin/user-management/${userId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#data-table').DataTable().ajax.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + response.message);
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat menghapus user');
                }
            });
        }
    }
</script>
@endpush
