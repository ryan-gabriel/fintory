import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    // Sesuaikan dengan URL lokal project Laravel Anda saat dijalankan (php artisan serve)
    baseUrl: 'http://127.0.0.1:8000',
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});
