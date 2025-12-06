describe('Fitur Registrasi User & Setup Awal', () => {
  beforeEach(() => {
    cy.visit('/register');
  });

  it('Halaman register memuat elemen dengan benar', () => {
    cy.contains('Daftar Akun').should('be.visible');
    cy.get('#email').should('be.visible');
    cy.get('#password').should('be.visible');
    cy.get('#password_confirmation').should('be.visible');
  });

  it('User baru berhasil daftar, setup lembaga, dan masuk dashboard', () => {
    // 1. Buat data unik agar tidak error "Email already taken"
    const timestamp = Date.now();
    const uniqueEmail = `owner${timestamp}@testing.com`;
    const password = 'password123';

    // 2. Isi Form Register
    cy.get('#email').type(uniqueEmail);
    cy.get('#password').type(password);
    cy.get('#password_confirmation').type(password);
    
    // Klik tombol daftar
    cy.get('#registerBtn').click();
    
    // 3. Verifikasi masuk ke halaman Setup Lembaga
    // (Karena user baru belum punya Role/Lembaga, biasanya diarahkan ke sini dulu)
    // Sesuaikan URL ini jika route-nya berbeda, misal: /auth/setup-lembaga
    cy.url({ timeout: 10000 }).should('include', '/setup/lembaga');

    // 4. Isi Form Setup Lembaga
    // Pastikan selector ini sesuai dengan name="" atau id="" di setup-lembaga.blade.php Anda
    // Saya menggunakan asumsi umum, silakan sesuaikan jika test gagal di sini
    
    // Contoh input (sesuaikan dengan form setup lembaga Anda):
    cy.get('input[name="name"]').type(`Toko Cypress ${timestamp}`); // Nama Lembaga
    cy.get('input[name="phone"]').type('081234567890');            // No Telp
    cy.get('input[name="email"]').type(`info${timestamp}@toko.com`); // Email Lembaga (jika ada)
    cy.get('textarea[name="address"]').type('Jl. Testing Automate No. 1'); // Alamat
    
    // Submit Setup
    cy.get('button[type="submit"]').click();

    // 5. Verifikasi Akhir: Masuk Dashboard
    // Jika setup berhasil, sistem akan otomatis meng-assign role 'owner'/'admin'
    // dan mengarahkan ke dashboard
    cy.url({ timeout: 10000 }).should('include', '/dashboard');
    
    // Pastikan elemen dashboard terlihat
    cy.contains('Dashboard').should('be.visible');
  });
});