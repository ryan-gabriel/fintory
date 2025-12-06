describe('Pengujian Halaman Edit Profile', () => {
  const originalEmail = 'haduh@mail.com';
  const originalPass = 'haduh12345';
  
  // Data sementara untuk pengujian
  const tempEmail = 'haduh1@mail.com';
  const tempPass = 'haduh123451';

  beforeEach(() => {
    // Selalu login dengan kredensial ORIGINAL
    cy.visit('http://127.0.0.1:8000/login')
    
    // Cek dulu apakah kita berada di halaman login
    // Jika sesi masih nyangkut, clear cookies
    cy.get('body').then(($body) => {
        if ($body.find('#email').length === 0) {
            cy.clearCookies();
            cy.reload();
        }
    });

    cy.get('#email').type(originalEmail)
    cy.get('#password').type(originalPass)
    cy.get('button[type="submit"]').click()

    // Pilih Role
    cy.url({ timeout: 10000 }).should('include', '/choose-role')
    cy.contains('Super').click()
    cy.contains('button', 'Continue', { matchCase: false }).click()

    // Ke Profile
    cy.url({ timeout: 10000 }).should('include', '/dashboard')
    cy.visit('http://127.0.0.1:8000/profile')
  })

  it('Should successfully update email and revert it back', () => {
    cy.intercept('POST', '**/profile').as('updateProfile');

    // 1. Ubah ke Email Baru
    cy.get('#email').clear().type(tempEmail).should('have.value', tempEmail);
    cy.contains('header', 'Profile Information').parent().find('button[type="submit"]').click();
    cy.wait('@updateProfile').its('response.statusCode').should('be.oneOf', [200, 302]);

    // 2. CLEANUP: Kembalikan ke Email Asal (Supaya test berikutnya tidak error login)
    cy.get('#email').clear().type(originalEmail).should('have.value', originalEmail);
    cy.contains('header', 'Profile Information').parent().find('button[type="submit"]').click();
    cy.wait('@updateProfile');
    
    // Pastikan nilai sudah kembali
    cy.get('#email').should('have.value', originalEmail);
  });

  it('Should successfully update password, login with new credentials, and revert password', () => {
    cy.intercept('POST', '**/password').as('updatePassword');

    // 1. Ubah Password (Original -> Temp)
    cy.get('#update_password_current_password').type(originalPass);
    cy.get('#update_password_password').type(tempPass);
    cy.get('#update_password_password_confirmation').type(tempPass);
    
    cy.get('#update_password_current_password').closest('form').find('button[type="submit"]').click();
    cy.wait('@updatePassword').its('response.statusCode').should('be.oneOf', [200, 302]);

    // 2. Logout Manual
    // Cara paling aman logout di Cypress adalah menghapus session
    cy.clearCookies();
    cy.visit('http://127.0.0.1:8000/login');

    // 3. Login dengan Password BARU (Temp)
    cy.get('#email').type(originalEmail); // Email masih original
    cy.get('#password').type(tempPass);   // Password pakai yang baru
    cy.get('button[type="submit"]').click();

    // Verifikasi berhasil login
    cy.url().should('include', '/choose-role');
    
    // Masuk lagi ke Profile untuk CLEANUP
    cy.visit('http://127.0.0.1:8000/profile');

    // 4. CLEANUP: Kembalikan Password ke Asal (Temp -> Original)
    cy.get('#update_password_current_password').type(tempPass); // Current-nya sekarang yang temp
    cy.get('#update_password_password').type(originalPass);     // Balikin ke original
    cy.get('#update_password_password_confirmation').type(originalPass);
    
    cy.get('#update_password_current_password').closest('form').find('button[type="submit"]').click();
    cy.wait('@updatePassword');
  });

});