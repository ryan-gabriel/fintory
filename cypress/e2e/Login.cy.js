describe('Pengujian Halaman Login', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
  })

  // Positive Test Cases

  it('TC1: Harus berhasil login dan redirect ke choose-role', () => {
    cy.get('#email').type('admin@gmail.com')
    cy.get('#password').type('12345678')
    cy.get('button[type="submit"]').click()

    // login validation via url
    cy.url({ timeout: 10000 }).should('include', '/choose-role') 
  })

  // Negative Test Cases

  it('TC2: Harus gagal jika password salah', () => {
    cy.get('#email').type('admin@gmail.com')
    cy.get('#password').type('passwordsalah') // Password salah
    cy.get('button[type="submit"]').click()


    cy.url().should('include', '/login')
    cy.get('.text-red-500').should('be.visible')
  })

  it('TC3: Harus gagal jika email belum terdaftar', () => {
    cy.get('#email').type('userbaru@gmail.com') // Email acak
    cy.get('#password').type('12345678')
    cy.get('button[type="submit"]').click()

    // error message validasi
    cy.get('.text-red-500').should('be.visible')
  })

  it('TC4: Harus memvalidasi format email yang tidak valid', () => {
    cy.get('#email').type('admingmail.com') 
    cy.get('#password').type('12345678')
    cy.get('button[type="submit"]').click()

    // html5 validation error 
    cy.get('#email').then(($input) => {
      expect($input[0].checkValidity()).to.be.false
      expect($input[0].validationMessage).to.exist
    })
  })

  it('TC5: Harus mencegah submit jika form kosong', () => {
    cy.get('button[type="submit"]').click()

    cy.get('#email').then(($input) => {
      expect($input[0].checkValidity()).to.be.false
    })
  })
})