describe("Keuangan - Cicilan E2E Test", () => {
    beforeEach(() => {
        cy.loginAsSuper("admin@gmail.com", "12345678");
        cy.visit("http://127.0.0.1:8000/dashboard/keuangan/cicilan");
    });

    it("TC-CLN-001: Menampilkan halaman daftar cicilan", () => {
        cy.get("div#data-table_wrapper", { timeout: 15000 }).should("exist");
    });

    it("TC-CLN-002: Berhasil menambahkan cicilan baru", () => {
        cy.get(".create-link").click();

        cy.url({ timeout: 15000 }).should(
            "include",
            "http://127.0.0.1:8000/dashboard/keuangan/cicilan/create"
        );

        cy.get("select#hutang").select(1);
        cy.get("select#metode_pembayaran").select("transfer");
        cy.get("input#jumlah_bayar").type("50000");
        cy.get('input[name="tanggal_bayar"]').type("10-12-2025");

        cy.get("body").click(0, 0);

        cy.get('textarea[name="deskripsi"]').type("Pembayaran awal cicilan");

        cy.get("textarea#deskripsi").type("Pembayaran awal cicilan");

        cy.contains("Submit").click();

        cy.url({ timeout: 15000 }).should(
            "include",
            "http://127.0.0.1:8000/dashboard/keuangan/cicilan"
        );
    });

    it("TC-CLN-003: Gagal jika jumlah bayar melebihi sisa hutang", () => {
        cy.get(".create-link").click();

        cy.url({ timeout: 15000 }).should(
            "include",
            "http://127.0.0.1:8000/dashboard/keuangan/cicilan/create"
        );

        cy.get("select#hutang").select(1);
        cy.get("select#metode_pembayaran").select("cash");
        cy.get("input#jumlah_bayar").type("999999999");
        cy.get('input[name="tanggal_bayar"]').type("10-12-2025");
        cy.get("body").click(0, 0);
        cy.get('textarea[name="deskripsi"]').type("Pembayaran cicilan");

        cy.contains("Submit").click();

        cy.url({ timeout: 15000 }).should(
            "include",
            "http://127.0.0.1:8000/dashboard/keuangan/cicilan/create"
        );

        cy.contains("sisa hutang").should("be.visible");
    });

    it("TC-CLN-004: Redirect ke login jika belum login", () => {
        cy.clearAllCookies();

        cy.visit("http://127.0.0.1:8000/dashboard/keuangan/cicilan");

        cy.url({ timeout: 15000 }).should(
            "include",
            "http://127.0.0.1:8000/login"
        );
    });
});
