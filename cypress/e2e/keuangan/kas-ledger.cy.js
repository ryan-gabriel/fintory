describe("Keuangan - Kas & Ledger E2E Test", () => {

    beforeEach(() => {
        cy.loginAsSuper("admin@gmail.com", "12345678");
        cy.visit("http://127.0.0.1:8000/dashboard/keuangan/kas-ledger");
        
        // Tambahan: Pastikan tabel index sudah muncul sebelum melakukan aksi apapun
        cy.get("#data-table_wrapper", { timeout: 10000 }).should("be.visible");
    });

    it("TC-KAS-001: Menampilkan halaman daftar Kas & Ledger", () => {
        cy.contains("h1", "Kas & Ledger").should("be.visible");
        cy.get(".create-link").should("be.visible");
    });

    it("TC-KAS-002: Berhasil membuat transaksi Kas baru", () => {
        // PERBAIKAN: Gunakan force: true untuk memastikan klik terjadi walau ada overlay
        cy.get(".create-link").click({ force: true });

        // PERBAIKAN: Tambah timeout agar toleransi loading halaman create lebih lama (10 detik)
        cy.url({ timeout: 10000 }).should("include", "/keuangan/kas-ledger/create");
        
        // Isi Form
        cy.get("select#tipe_transaksi").select("INCOME");
        cy.get("select#outlet").select("1");
        cy.get("input#jumlah").clear().type("5000000");
        cy.get("input#sumber").clear().type("Dana Hibah Revisi");

        // Isi Tanggal (Force type untuk datepicker)
        cy.get("input#tanggal").click().type("01-01-2025", { force: true, delay: 100 });
        cy.get("body").click(0, 0); // Tutup popup tanggal

        cy.get("textarea#description").type("Testing e2e cypress revisi");

        // PERBAIKAN: Jangan gunakan .contains('Submit') jika teksnya memiliki banyak spasi
        // Gunakan selector atribut langsung, ini lebih stabil
        cy.get('button[type="submit"]').click();

        // Verifikasi Redirect
        cy.url({ timeout: 10000 }).should("eq", "http://127.0.0.1:8000/dashboard/keuangan/kas-ledger");
        cy.get("table tbody").should("contain", "Dana Hibah Revisi");
    });

    it("TC-KAS-003: Fitur Pencarian berfungsi", () => {
        const keyword = "eum"; 

        cy.get("#dt-search-0").should('be.visible').clear().type(`${keyword}{enter}`);

        // PERBAIKAN: Tambahkan timeout: 10000 (10 detik) pada pengecekan loading
        // Error sebelumnya terjadi karena loading > 4000ms (default cypress)
        cy.get("#data-table_processing", { timeout: 10000 }).should("not.be.visible");

        // Verifikasi data
        cy.get("table tbody").should("contain", keyword);
    });

    it("TC-KAS-004: Validasi Form Wajib Diisi (Negative Test)", () => {
        cy.get(".create-link").click({ force: true });

        // PERBAIKAN: Selector tombol disamakan dengan TC-002
        // Langsung klik submit tanpa isi data
        cy.get('button[type="submit"]').click();

        // Cek validasi browser pada field 'jumlah'
        cy.get("input#jumlah").then(($input) => {
            expect($input[0].checkValidity()).to.be.false;
        });

        // Pastikan URL masih di halaman create (tidak terkirim)
        cy.url().should("include", "/create");
    });

});