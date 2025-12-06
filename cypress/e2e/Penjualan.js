describe('Pengujian Halaman Riwayat Penjualan', () => {
  
  beforeEach(() => {
    // 1. Login
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('#email').type('admin@gmail.com')
    cy.get('#password').type('12345678')
    cy.get('button[type="submit"]').click()

    // 2. Pilih Role
    cy.url({ timeout: 10000 }).should('include', '/choose-role')
    cy.contains('Super').click() 
    cy.contains('button', 'Continue', { matchCase: false }).click()
    cy.url({ timeout: 10000 }).should('include', '/dashboard')
    // route to Penjualan page
    cy.visit('http://127.0.0.1:8000/dashboard/penjualan')
  })


  it('TC1: Harus memfilter data berdasarkan kata kunci pencarian', () => {
    cy.get('#dt-search-0').should('be.visible').clear().type('Jaylan{enter}')
    cy.wait(1000)
    cy.get('table').should('contain', 'Jaylan')
  })

  it('TC2:  Navigasi paging tabel ke halaman selanjutnya', () => {
    cy.get('.dt-paging-button.next').click()
    cy.get('#data-table_info').should('contain', 'Menampilkan 11')
  })

  it('TC3: Tombol "Buat Transaksi Baru" berfungsi', () => {
    cy.contains('Buat Transaksi Baru').click()
    cy.url().should('include', '/create') 
  })

  it('TC4: Link "Detail" membuka rincian transaksi', () => {
    cy.get('table tbody tr').first().contains('Detail').click()
    cy.url().should('match', /\/dashboard\/penjualan\/\d+/)
  })
})