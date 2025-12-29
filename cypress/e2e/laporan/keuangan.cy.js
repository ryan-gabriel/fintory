describe("Laporan Keuangan - E2E Test", () => {

    beforeEach(() => {
        // 1. Login
        cy.loginAsSuper("admin@gmail.com", "12345678");

        // 2. Handle Role Selection
        cy.url().then((url) => {
            if (url.includes('/choose-role')) {
                cy.contains('Super').click();
                cy.contains('button', 'CONTINUE', { matchCase: false }).click();
            }
        });

        // 3. Visit Halaman Laporan Keuangan
        cy.visit("http://127.0.0.1:8000/dashboard/laporan/keuangan");

        // 4. Pastikan Tabel sudah dimuat
        cy.get("#data-table_wrapper", { timeout: 10000 }).should("be.visible");
    });

    it("TC-LAP-001: Menampilkan Halaman & Ringkasan Keuangan", () => {
        // Validasi Judul
        cy.contains("h1", "Laporan Keuangan").should("be.visible");
        cy.get("#current_selected_outlet_name").should("contain", "Semua Outlet");

        // Validasi Kartu Ringkasan (ID diambil dari HTML)
        // Cek Keberadaan Saldo
        cy.get("#totalSaldo").should("be.visible");
        // Opsional: Cek nilai awal sesuai snapshot HTML (9.397.833)
        // cy.get("#totalSaldo").should("contain", "9.397.833");

        // Cek Keberadaan Hutang
        cy.get("#totalHutang").should("be.visible");
        // Opsional: Cek nilai awal sesuai snapshot HTML (11.515.732)
        // cy.get("#totalHutang").should("contain", "11.515.732");
    });

    it("TC-LAP-002: Menampilkan Tabel Data dengan Kolom yang Benar", () => {
        // Validasi Header Tabel
        cy.get("table thead").should("contain", "Tanggal")
            .and("contain", "Outlet")
            .and("contain", "Tipe")
            .and("contain", "Sumber")
            .and("contain", "Jumlah")
            .and("contain", "Saldo Setelah");

        // Validasi Data Baris Pertama (Sample: Nienow PLC)
        cy.get("table tbody tr").first().should("contain", "Nienow PLC")
            .and("contain", "INCOME");
    });

    it("TC-LAP-003: Fitur Filter Tanggal Tersedia", () => {
        // Memastikan input datepicker ada
        cy.get("#datepicker-range-start").should("be.visible");
        cy.get("#datepicker-range-end").should("be.visible");
    });

    it("TC-LAP-004: Fitur Pencarian Berfungsi", () => {
        // Keyword diambil dari HTML: "Terry PLC"
        const keyword = "Terry PLC";
        
        // 1. Ketik Keyword
        // Gunakan selector generic input[type="search"] karena ID dt-search-25 bisa berubah
        cy.get('input[type="search"]')
            .should('be.visible')
            .clear()
            .type(`${keyword}{enter}`);

        // 2. Wait (Stabilisasi)
        cy.wait(1000);

        // 3. Verifikasi
        cy.get("table tbody").should("contain", keyword);
        // Pastikan data baris pertama sebelumnya (Nienow PLC) sudah hilang/terganti
        cy.get("table tbody").should("not.contain", "Nienow PLC");
    });

    it("TC-LAP-005: Link Detail Berfungsi", () => {
        // Klik link "Detail" pada baris pertama
        cy.get("table tbody tr").first().contains("Detail").click();

        // Validasi URL redirect ke halaman detail (pola: /laporan/keuangan/{id})
        // Regex \d+ berarti angka ID berapapun
        cy.url().should("match", /\/dashboard\/laporan\/keuangan\/\d+/);
    });

});