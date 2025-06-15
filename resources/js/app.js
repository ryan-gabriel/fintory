import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'aos/dist/aos.css';
// Import JavaScript AOS
import AOS from 'aos';

// Inisialisasi AOS dengan pengaturan default
document.addEventListener('DOMContentLoaded', () => {
  AOS.init({
    duration: 800, // Durasi animasi dalam milidetik
    once: true,    // Apakah animasi hanya berjalan sekali
    offset: 50,    // Offset (dalam px) dari titik pemicu asli
  });
});