export const PAGE_CONFIGS = {
    "/dashboard/saldo-outlet": {
        url: "/dashboard/saldo-outlet/data",
        columns: [
            {
                data: 0,
                name: "name",
                title: "Nama Outlet",
            },
            {
                data: 1,
                name: "address",
                title: "Alamat",
            },
            {
                data: 2,
                name: "balance",
                title: "Saldo",
                className: "text-right",
                orderable: false,
                searchable: false,
            },
        ],
    },

    "/dashboard/outlet-karyawan": {
        url: "/dashboard/outlet-karyawan/data",
        columns: [
            {
                data: 0,
                name: "name",
                title: "Nama Outlet",
            },
            {
                data: 1,
                name: "address",
                title: "Alamat",
            },
            {
                data: 2,
                name: "phone",
                title: "No. Telp",
            },
            {
                data: 3,
                name: "action",
                title: "Aksi",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
    },

    "/dashboard/outlet-karyawan/saldo": {
        url: "/dashboard/outlet-karyawan/saldo/data",
        columns: [
            {
                data: 0,
                name: "name",
                title: "Nama Outlet",
            },
            // Pastikan baris ini menggunakan 'text-center'
            {
                data: 1,
                name: "saldo",
                title: "Saldo Saat Ini",
                className: "text-center",
                orderable: false,
                searchable: false,
            },
            {
                data: 2,
                name: "last_updated",
                title: "Terakhir Diperbarui",
                orderable: false,
                searchable: false,
            },
        ],
    },

    "/dashboard/keuangan/kas-ledger": {
        url: "/dashboard/keuangan/kas-ledger/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Tipe Transaksi",
            },
            {
                data: 2,
                title: "Sumber",
            },
            {
                data: 3,
                title: "Jumlah",
            },
            {
                data: 4,
                title: "Saldo Akhir",
            },
            {
                data: 5,
                title: "action",
            },
        ],
    },
    "/dashboard/keuangan/cicilan": {
        url: "/dashboard/keuangan/cicilan/data",
        columns: [
            {
                data: 0,
                title: "Tanggal Bayar",
            },
            {
                data: 1,
                title: "Pemberi Hutang",
            },
            {
                data: 2,
                title: "Jumlah Bayar",
            },
            {
                data: 3,
                title: "Sisa Hutang",
            },
            {
                data: 4,
                title: "Metode Pembayaran",
            },
            {
                data: 5,
                title: "Action",
            },
        ],
    },
    "/dashboard/keuangan/hutang": {
        url: "/dashboard/keuangan/hutang/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Outlet",
            },
            {
                data: 2,
                title: "Pemberi Hutang",
            },
            {
                data: 3,
                title: "Jumlah Hutang",
            },
            {
                data: 4,
                title: "Sisa Hutang",
            },
            {
                data: 5,
                title: "Action",
            },
        ],
    },
    "/dashboard/laporan/keuangan": {
        url: "/dashboard/laporan/keuangan/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Tipe",
            },
            {
                data: 2,
                title: "Sumber",
            },
            {
                data: 3,
                title: "Deskripsi",
            },
            {
                data: 4,
                title: "Jumlah",
            },
            {
                data: 5,
                title: "Saldo Setelah",
            },
            {
                data: 6,
                title: "Outlet",
            },
            {
                data: 7,
                title: "Detail",
            },
        ],
    },
    "/dashboard/laporan/stok/mutasi-stok": {
        url: "/dashboard/laporan/stok/mutasi-stok/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Outlet",
            },
            {
                data: 2,
                title: "Produk",
            },
            {
                data: 3,
                title: "Tipe",
            },
            {
                data: 4,
                title: "Jumlah",
            },
            {
                data: 5,
                title: "Detail",
            },
        ],
    },
    "/dashboard/laporan/stok/produk": {
        url: "/dashboard/laporan/stok/produk/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Barang",
            },
            {
                data: 2,
                title: "Kategori",
            },
            {
                data: 3,
                title: "Outlet",
            },
            {
                data: 4,
                title: "Harga Jual",
            },
            {
                data: 5,
                title: "Stok",
            },
            {
                data: 6,
                title: "Status",
            },
            {
                data: 7,
                title: "Detail",
            },
        ],
    },
    "/dashboard/produk-stok/barang": {
        url: "/dashboard/produk-stok/barang/data",
        columns: [
            {
                data: 0,
                title: "Nama",
            },
            {
                data: 1,
                title: "Deskripsi",
            },
            {
                data: 2,
                title: "action",
            },
        ],
    },
    "/dashboard/produk-stok/kategori": {
        url: "/dashboard/produk-stok/kategori/data",
        columns: [
            {
                data: 0,
                title: "Nama Kategori",
            },
            {
                data: 1,
                title: "Deskripsi",
            },
            {
                data: 2,
                title: "action",
            },
        ],
    },
    "/dashboard/produk-stok/produk": {
        url: "/dashboard/produk-stok/produk/data",
        columns: [
            {
                data: 0,
                title: "Nama Barang",
            },
            {
                data: 1,
                title: "Kategori",
            },
            {
                data: 2,
                title: "Outlet",
            },
            {
                data: 3,
                title: "Harga Jual",
            },
            {
                data: 4,
                title: "Stok",
            },
            {
                data: 5,
                title: "action",
            },
        ],
    },
    "/dashboard/produk-stok/mutasi": {
        url: "/dashboard/produk-stok/mutasi/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "Produk",
            },
            {
                data: 2,
                title: "Outlet",
            },
            {
                data: 3,
                title: "Tipe",
            },
            {
                data: 4,
                title: "Kuantitas",
            },
            {
                data: 5,
                title: "Referensi",
            },
        ],
    },
    "/dashboard/penjualan/riwayat": {
        url: "/dashboard/penjualan/riwayat/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "No. Transaksi",
            },
            {
                data: 2,
                title: "Outlet",
            },
            {
                data: 3,
                title: "Pelanggan",
            },
            {
                data: 4,
                title: "Total",
            },
        ],
    },

    "/dashboard/laporan/penjualan": {
        url: "/dashboard/laporan/penjualan/data",
        columns: [
            {
                data: 0,
                title: "Tanggal",
            },
            {
                data: 1,
                title: "No. Transaksi",
            },
            {
                data: 2,
                title: "Outlet",
            },
            {
                data: 3,
                title: "Pelanggan",
            },
            {
                data: 4,
                title: "Total",
                className: "text-right",
            },
            {
                data: 5,
                title: "Aksi",
                className: "text-center",
                orderable: false,
                searchable: false,
            },
        ],
    },
    "/dashboard/penjualan": {
        url: "/dashboard/penjualan/data",
        columns: [
            {
                data: 0,
                name: "sale_date",
                title: "Tanggal",
            },
            {
                data: 1,
                name: "id",
                title: "No. Transaksi",
            },
            {
                data: 2,
                name: "outlet.name",
                title: "Outlet",
            },
            {
                data: 3,
                name: "customer_name",
                title: "Pelanggan",
            },
            {
                data: 4,
                name: "total",
                title: "Total",
                className: "text-right",
            },
            {
                data: 5,
                name: "action",
                title: "Aksi",
                className: "text-center",
                orderable: false,
                searchable: false,
            },
        ],
    },
    "/dashboard/admin/user-management": {
        url: "/dashboard/admin/user-management/data",
        columns: [
            { data: 0, title: "Nama Karyawan", name: "employee.name" },
            { data: 1, title: "Email", name: "email" },
            {
                data: 2,
                title: "Role",
                name: "roles.display_name",
                orderable: false,
                searchable: false,
            },
            { data: 3, title: "Waktu Dibuat", name: "created_at" },
            {
                data: 4,
                title: "Aksi",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[3, "desc"]],
    },
};
