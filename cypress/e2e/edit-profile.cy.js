describe('Pengujian Halaman Edit Profile', () => {
  // 1. Definisi kredensial AWAL (untuk Login)
  const userEmail = 'haduh@mail.com';
  const userPass = 'haduh12345';

  beforeEach(() => {
    // Login dengan kredensial awal
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('#email').type(userEmail)
    cy.get('#password').type(userPass)
    cy.get('button[type="submit"]').click()

    // Pilih Role
    cy.url({ timeout: 10000 }).should('include', '/choose-role')
    cy.contains('Super').click()
    cy.contains('button', 'Continue', { matchCase: false }).click()

    // Masuk ke halaman Profile
    cy.url({ timeout: 10000 }).should('include', '/dashboard')
    cy.visit('http://127.0.0.1:8000/profile')
  })

  it('Should successfully upload photo and update email', () => {
    cy.intercept('POST', '**/profile').as('updateProfile');

    // Upload Foto Profil
    cy.get('input[name="profile_picture"]').selectFile('cypress/fixtures/avatar.png', { force: true });

    // Update Email
    // Mengubah email menjadi haduh1@mail.com (ditambah angka 1)
    cy.get('#email')
      .clear()
      .type('haduh1@mail.com') 
      .should('have.value', 'haduh1@mail.com');

    // Klik tombol Save
    cy.contains('header', 'Profile Information')
      .parent()
      .find('button[type="submit"]')
      .click();

    // Verifikasi request berhasil
    cy.wait('@updateProfile').its('response.statusCode').should('be.oneOf', [200, 302]);
  });

  it('Should successfully update the password', () => {
    cy.intercept('POST', '**/password').as('updatePassword');

    // 1. Isi Current Password (Gunakan password lama/awal)
    cy.get('#update_password_current_password').type(userPass);

    // 2. Isi New Password (ditambah angka 1 di ujung)
    const newPass = 'haduh123451'; 
    cy.get('#update_password_password').type(newPass);

    // 3. Konfirmasi New Password
    cy.get('#update_password_password_confirmation').type(newPass);

    // 4. Klik tombol Save pada form Password
    cy.get('#update_password_current_password')
      .closest('form')
      .find('button[type="submit"]')
      .click();

    // 5. Verifikasi request berhasil
    cy.wait('@updatePassword').its('response.statusCode').should('be.oneOf', [200, 302]);
  });

});