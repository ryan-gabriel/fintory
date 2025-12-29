describe("Manajemen Outlet - Saldo Outlet E2E Test", () => {

    beforeEach(() => {
        cy.loginAsSuper("admin@gmail.com", "12345678");

        // Handle Role
        cy.url().then((url) => {
            if (url.includes('/choose-role')) {
                cy.contains('Super').click();
                cy.contains('button', 'CONTINUE', { matchCase: false }).click();
            }
        });

        cy.visit("http://127.0.0.1:8000/dashboard/outlet-karyawan/saldo");
        cy.get("#data-table_wrapper", { timeout: 10000 }).should("be.visible");
    });

    it("TC-SALDO-001: Menampilkan halaman Saldo Outlet dengan benar", () => {
        cy.contains("h1", "Saldo Outlet").should("be.visible");
        cy.get("table thead").should("contain", "Nama Outlet")
            .and("contain", "Saldo Saat Ini");
    });

    it("TC-SALDO-002: Fitur Pencarian berfungsi", () => {
        // Keyword disesuaikan dengan screenshot Anda (Kunde-Kihn)
        // Anda bisa ganti 'Kunde' menjadi 'Jaylan' jika data tersebut memang ada.
        const keyword = "Kunde"; 

        // 1. Ketik Keyword
        // Selector input[type="search"] lebih aman daripada #dt-search-0 karena ID bisa berubah
        cy.get('input[type="search"]')
            .should('be.visible')
            .clear()
            .type(`${keyword}{enter}`);

        // 2. WAIT (Sesuai permintaan Anda)
        // Memberi jeda 1 detik agar tabel selesai reload
        cy.wait(1000);

        // 3. Verifikasi
        // Pastikan tabel sekarang mengandung kata yang dicari
        cy.get('table').should('contain', keyword);
    });

});