describe("Manajemen Outlet - E2E Test (Tanpa Search)", () => {

    beforeEach(() => {
        // 1. Login
        cy.loginAsSuper("admin@gmail.com", "12345678");
        
        // 2. Pilih Role (Logika penanganan role)
        cy.url().then((url) => {
            if (url.includes('/choose-role')) {
                cy.contains('Super').click();
                cy.contains('button', 'CONTINUE', { matchCase: false }).click();
            }
        });

        // 3. Visit Halaman Outlet
        cy.visit("http://127.0.0.1:8000/dashboard/outlet-karyawan");
        
        // 4. Pastikan Tabel sudah dimuat (tunggu wrapper tabel)
        cy.get("#data-table_wrapper", { timeout: 10000 }).should("be.visible");
    });

    it("TC-OUT-001: Menampilkan halaman daftar Outlet dengan benar", () => {
        // Validasi Judul
        cy.contains("h1", "Manajemen Outlet").should("be.visible");
        
        // Validasi Tombol Tambah Outlet
        cy.get(".create-link").should("be.visible").and("contain", "Tambah Outlet");
        
        // Validasi Kolom Tabel Utama
        cy.get("table thead").should("contain", "Nama Outlet")
            .and("contain", "Alamat")
            .and("contain", "No. Telp");
    });

    it("TC-OUT-002: Berhasil menambah Outlet Baru", () => {
        // 1. Klik Tambah Outlet
        cy.get(".create-link").click({ force: true });

        // 2. Verifikasi masuk halaman create
        cy.url({ timeout: 10000 }).should("include", "/outlet-karyawan/create");
        cy.contains("h1", "Tambah Outlet Baru").should("be.visible");

        // 3. Isi Form
        // Kita gunakan Timestamp agar nama unik dan mudah diverifikasi tanpa search
        const uniqueName = "Outlet Test " + new Date().getTime(); 
        
        cy.get("#name").type(uniqueName);
        cy.get("#phone").type("081299998888");
        cy.get("#address").type("Jl. Percobaan No. 123");

        // 4. Submit (Gunakan ID #btn-submit sesuai HTML Create)
        cy.get("#btn-submit").click();

        // 5. Verifikasi Redirect
        cy.url({ timeout: 10000 }).should("eq", "http://127.0.0.1:8000/dashboard/outlet-karyawan");
        
        // 6. Verifikasi Data Masuk (Cek langsung di tabel tanpa filter search)
        // Cypress akan men-scan seluruh tabel yang terlihat
        cy.get("table tbody").should("contain", uniqueName);
    });

    it("TC-OUT-003: Berhasil Mengedit Outlet", () => {
        // 1. Ambil baris pertama yang memiliki tombol Edit
        cy.get(".edit-link").first().click();

        // 2. Verifikasi masuk halaman Edit
        cy.url({ timeout: 10000 }).should("include", "/edit");
        
        // 3. Update Data
        const updatedName = "Outlet Updated " + new Date().getTime();
        
        cy.get("#name").clear().type(updatedName);
        cy.get("#phone").clear().type("087777777777");

        // 4. Submit Update
        // Di halaman Edit, tombolnya adalah <button>Update</button> (tanpa ID btn-submit)
        // Kita cari tombol submit yang mengandung kata "Update"
        cy.get('button[type="submit"]').contains("Update").click();

        // 5. Verifikasi Redirect
        cy.url().should("eq", "http://127.0.0.1:8000/dashboard/outlet-karyawan");

        // 6. Verifikasi Data Berubah
        cy.get("table tbody").should("contain", updatedName);
    });

    it("TC-OUT-004: Validasi Form Wajib Diisi (Negative Test)", () => {
        // 1. Masuk halaman create
        cy.get(".create-link").click({ force: true });

        // 2. Klik Submit tanpa isi data apapun
        cy.get("#btn-submit").click();

        // 3. Cek validasi browser pada field Nama (#name)
        // HTML5 Validation check
        cy.get("#name").then(($input) => {
            expect($input[0].checkValidity()).to.be.false;
        });

        // 4. Pastikan URL tidak berubah (User tertahan di halaman create)
        cy.url().should("include", "/create");
    });

    it("TC-OUT-005: Tombol Delete tersedia", () => {
        // Hanya memastikan tombol delete ada (agar tidak menghapus data sembarangan)
        cy.get(".delete-outlet").first().should("be.visible").and("contain", "Delete");
    });

});