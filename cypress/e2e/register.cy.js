describe('Modul Registrasi & Onboarding', () => {
    
  beforeEach(() => {
    // Selalu mulai dari halaman register yang bersih
    cy.visit('/register');
  });

  // --- POSITIVE TEST CASE (HAPPY PATH) ---
  
  it('TC-REG-001: User baru berhasil daftar dan setup lembaga (Happy Path)', () => {
    const timestamp = Date.now();
    const uniqueEmail = `owner${timestamp}@testing.com`;
    const password = 'password123';

    // 1. Register
    cy.get('#email').type(uniqueEmail);
    cy.get('#password').type(password);
    cy.get('#password_confirmation').type(password);
    cy.get('#registerBtn').click();
    
    // 2. Setup Lembaga
    cy.url({ timeout: 10000 }).should('include', '/setup/lembaga');
    
    cy.get('input[name="name"]').type(`Toko Cypress ${timestamp}`); 
    cy.get('input[name="phone"]').type('081234567890');
    // Sesuaikan selector alamat jika menggunakan textarea
    cy.get('textarea[name="address"]').type('Jl. Testing Automate No. 1'); 
    
    cy.get('button[type="submit"]').click();

    // 3. Verifikasi Dashboard
    cy.url({ timeout: 10000 }).should('include', '/dashboard');
    cy.contains('Dashboard').should('be.visible');
  });

  // --- NEGATIVE TEST CASES ---

  it('TC-REG-002: Gagal daftar jika email sudah digunakan', () => {
    // Gunakan email yang PASTI ada di database (dari seeder)
    cy.get('#email').type('admin@gmail.com');
    cy.get('#password').type('password123');
    cy.get('#password_confirmation').type('password123');
    
    cy.get('#registerBtn').click();

    // Verifikasi pesan error muncul dan TIDAK pindah halaman
    cy.contains('email has already been taken').should('be.visible');
    cy.url().should('include', '/register');
  });

  it('TC-REG-003: Gagal daftar jika password konfirmasi beda', () => {
    cy.get('#email').type(`fail${Date.now()}@test.com`);
    cy.get('#password').type('passwordA');
    cy.get('#password_confirmation').type('passwordB'); // Beda
    
    cy.get('#registerBtn').click();

    // Verifikasi pesan error password
    // Sesuaikan teks error dengan bahasa aplikasi Anda (Inggris/Indo)
    cy.contains(/match/i).should('be.visible'); 
  });

  it('TC-REG-004: Validasi field required (Form Kosong)', () => {
    // Langsung klik daftar tanpa isi apa-apa
    cy.get('#registerBtn').click();

    // Cek validasi HTML5 pada field email
    cy.get('#email').then(($input) => {
      expect($input[0].validationMessage).to.not.be.empty;
    });
    
    // Pastikan URL tidak berubah
    cy.url().should('include', '/register');
  });

});