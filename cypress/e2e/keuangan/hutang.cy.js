describe("Keuangan - Hutang E2E Test", () => {

    beforeEach(() => {
        // Login & Visit
        cy.loginAsSuper("admin@gmail.com", "12345678");
        cy.visit("http://127.0.0.1:8000/dashboard/keuangan/hutang");
        
        // Pastikan tabel index sudah muncul sebelum tes dimulai
        // Note: ID wrapper sesuai HTML Index Anda
        cy.get("#data-table_wrapper", { timeout: 10000 }).should("be.visible");
    });

    it("TC-HUT-001: Menampilkan halaman daftar Hutang dengan benar", () => {
        cy.contains("h1", "Hutang").should("be.visible");
        
        // Verifikasi tombol Create ada
        cy.get(".create-link").should("be.visible").and("contain", "Create +");
        
        // Verifikasi kolom tabel utama terlihat
        cy.get("table thead").should("contain", "Pemberi Hutang")
            .and("contain", "Sisa Hutang");
    });

    it("TC-HUT-002: Berhasil membuat Hutang baru (Outlet: Lynch Ltd)", () => {
        // 1. Klik tombol Create
        cy.get(".create-link").click({ force: true });

        // 2. Verifikasi masuk halaman form
        cy.url({ timeout: 10000 }).should("include", "/keuangan/hutang/create");
        cy.get("#form-create").should("be.visible"); // Selector ID Form

        // 3. Isi Form
        // Pilih Outlet: Lynch Ltd (Value = 7 di HTML)
        cy.get("select#outlet").select("7");

        // Isi Nama Pemberi Hutang
        cy.get("input#nama_pemberi_hutang").type("Vendor Lynch Ltd Jaya");

        // Isi Jumlah Hutang
        cy.get("input#jumlah").clear().type("7500000");

        // Isi Tanggal (Force type untuk datepicker Flowbite)
        cy.get("input#tanggal").click().type("01-01-2025", { force: true, delay: 100 });
        cy.get("body").click(0, 0); // Tutup popup tanggal agar tidak menghalangi

        // Isi Deskripsi
        cy.get("textarea#description").type("Hutang pengadaan stok awal tahun");

        // 4. Submit
        // Menggunakan ID #btn-submit sesuai HTML create Anda
        cy.get("#btn-submit").click();

        // 5. Verifikasi Redirect & Data
        cy.url({ timeout: 10000 }).should("eq", "http://127.0.0.1:8000/dashboard/keuangan/hutang");
        
        // Validasi data baru muncul di tabel
        cy.get("table tbody").should("contain", "Vendor Lynch Ltd Jaya");
        cy.get("table tbody").should("contain", "Lynch Ltd");
    });

    it("TC-HUT-003: Fitur Pencarian berfungsi", () => {
        // Data tes: "Zoie Heathcote" (Row 1)
        // Data pembanding: "Emmanuel Botsford" (Row 2 - harus hilang saat difilter)
        const keyword = "Zoie Heathcote";
        const excludedKeyword = "Emmanuel Botsford";

        // 1. Ketik Keyword di search box
        // Menggunakan selector generic input[type="search"] agar tidak error jika ID berubah
        cy.get('input[type="search"]').should('be.visible').clear().type(`${keyword}{enter}`);

        // --- PERBAIKAN: HAPUS PENGECEKAN LOADING ---
        // Pengecekan .dt-processing sering bikin flaky (gagal padahal fitur jalan).
        // Kita ganti dengan validasi data langsung.

        // 2. Verifikasi Filter Berhasil (Assertion Logic)
        
        // Assert A: Pastikan data yang dicari MUNCUL
        cy.get("table tbody").should("contain", keyword);

        // Assert B: Pastikan data lain (Emmanuel) SUDAH HILANG
        // Cypress secara otomatis akan menunggu (retry) sampai teks ini benar-benar hilang dari DOM
        cy.get("table tbody").should("not.contain", excludedKeyword);
    });

    it("TC-HUT-004: Validasi Form Wajib Diisi (Negative Test)", () => {
        // 1. Masuk halaman create
        cy.get(".create-link").click({ force: true });

        // --- PERBAIKAN DI SINI ---
        // Tunggu dan pastikan kita sudah benar-benar ada di halaman Create
        // Cek URL harus mengandung '/create'
        cy.url({ timeout: 10000 }).should("include", "/keuangan/hutang/create");
        
        // Pastikan Form sudah muncul (selector ID form sesuai HTML Anda)
        cy.get("#form-create").should("be.visible");
        // -------------------------

        // 2. Klik Submit tanpa isi data
        // Sekarang aman untuk diklik karena halaman sudah dipastikan siap
        cy.get("#btn-submit").click();

        // 3. Cek validasi browser pada field wajib (contoh: Jumlah)
        cy.get("input#jumlah").then(($input) => {
            // Memastikan browser mendeteksi field ini invalid (karena required)
            expect($input[0].checkValidity()).to.be.false;
        });

        // 4. Pastikan URL tidak berubah (User tertahan di halaman create)
        cy.url().should("include", "/create");
    });

});