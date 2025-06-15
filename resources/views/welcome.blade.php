<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="w-full flex justify-center">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="w-full">
    <header class="w-full bg-[#043873] text-text-light flex justify-center sticky top-0 z-50">
        <nav class="w-[95%] flex justify-between max-w-[1480px] h-20 items-center">
            <img src="{{ asset('images/logo.svg') }}" alt="Fintory Logo" class="h-14 w-auto" />
            <div class="flex gap-16 h-full items-center">
                {{-- ANIMASI: Menambahkan transisi pada link navigasi --}}
                <a href="" class="flex items-center gap-2 transition-opacity duration-300 hover:opacity-80">Produk <i class="fa-solid fa-chevron-down"></i></a>
                <a href="" class="flex items-center gap-2 transition-opacity duration-300 hover:opacity-80">Layanan <i class="fa-solid fa-chevron-down"></i></a>
                <a href="" class="flex items-center gap-2 transition-opacity duration-300 hover:opacity-80">Solusi Bisnis <i class="fa-solid fa-chevron-down"></i></a>
                <a href="" class="flex items-center gap-2 transition-opacity duration-300 hover:opacity-80">Harga <i class="fa-solid fa-chevron-down"></i></a>
            </div>
            <div class="font-medium flex gap-6">
                {{-- ANIMASI: Menambahkan efek hover mengangkat --}}
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl text-primary bg-button-secondary transition-transform duration-300 hover:-translate-y-1">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="p-4 rounded-xl text-text-light bg-button-primary transition-transform duration-300 hover:-translate-y-1">
                    Coba Gratis 14 Hari &rarr;
                </a>
            </div>
        </nav>
    </header>
    <main class="w-full">
        <div class="w-full bg-[#043873] flex justify-center" style="background-image: url('images/hero-bg.svg'); background-repeat: no-repeat; background-position: left top; background-size: cover;">
            <section class="max-w-[1480px] flex flex-col lg:flex-row w-[95%] items-center justify-between py-12 md:py-20 lg:py-28 text-white gap-8 lg:gap-12">
                {{-- ANIMASI: fade-right untuk teks dan fade-left untuk gambar --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-4 md:gap-6 lg:gap-8 order-2 lg:order-1" data-aos="fade-right">
                    <h1 class="text-3xl sm:text-4xl font-bold">Aplikasi Manajemen, Bisnis, Operasional Serba
                        Otomatis</h1>
                    <p class="text-sm sm:text-base">Fintory adalah aplikasi manajemen bisnis yang dirancang untuk
                        mengotomatiskan operasional Anda, sehingga lebih efisien dan bebas dari kerepotan. Dengan
                        fitur cerdas yang mencakup keuangan, manajemen tim, inventaris, hingga analisis data,
                        Fintory membantu Anda menghemat waktu, meningkatkan produktivitas, dan mengontrol bisnis
                        dengan lebih mudah. Kelola semua aspek bisnis dalam satu platform terpadu, kapan saja dan di
                        mana saja. Saatnya beralih ke sistem yang lebih pintar dan otomatis bersama Fintory! 🚀</p>
                    <button class="w-fit p-3 sm:p-4 bg-[#4F9CF9] rounded-xl text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Coba
                        Gratis 14 Hari &rarr;</button>
                </div>
                <div class="w-full lg:w-1/2 order-1 lg:order-2" data-aos="fade-left">
                    <img src="images/hero-img.svg" alt="hero-image" class="w-full h-auto scale-110" />
                </div>
            </section>
        </div>

        @php
            $sections = [
                [
                    'bg' => 'bg-white',
                    'img' => 'images/fitur-1.svg',
                    'order_img' => 'lg:order-2',
                    'order_text' => 'lg:order-1',
                    'content' => 'fitur_unggulan'
                ],
                [
                    'bg' => 'bg-white',
                    'img' => 'images/fitur-2.svg',
                    'order_img' => 'lg:order-1',
                    'order_text' => 'lg:order-2',
                    'content' => 'kenapa_fintory'
                ],
                [
                    'bg' => 'bg-[#043873]',
                    'img' => 'images/fitur-3.svg',
                    'order_img' => 'lg:order-2',
                    'order_text' => 'lg:order-1',
                    'content' => 'kelola_bisnis'
                ],
                [
                    'bg' => 'bg-white',
                    'img' => 'images/fitur-4.svg',
                    'order_img' => 'lg:order-1',
                    'order_text' => 'lg:order-2',
                    'content' => 'otomatisasi_keuangan'
                ]
            ];
        @endphp

        @foreach($sections as $section)
        <div class="w-full flex justify-center {{ $section['bg'] }}">
            <section class="max-w-[1480px] flex flex-col lg:flex-row w-[95%] items-center justify-between py-12 md:py-20 lg:py-28 {{ $section['bg'] == 'bg-white' ? 'text-[#212529]' : 'text-white' }} gap-8 lg:gap-12">
                <div class="w-full lg:w-1/2 flex flex-col gap-4 md:gap-6 lg:gap-8 order-2 {{ $section['order_text'] }}" data-aos="fade-up">
                    @if($section['content'] == 'fitur_unggulan')
                        <h1 class="text-3xl sm:text-4xl font-bold">Fitur Unggulan</h1>
                        <ul class="list-none space-y-5">
                            <li class="flex items-start space-x-2"> <span class="text-xl pt-1">💡</span> <span><strong>Otomatisasi Penuh</strong> – Hemat waktu dengan sistem otomatisasi yang mengelola operasional bisnis Anda secara efisien.</span> </li>
                            <li class="flex items-start space-x-2"> <span class="text-xl pt-1">📊</span> <span><strong>Laporan Real-Time</strong> – Dapatkan laporan keuangan, penjualan, dan inventaris kapan saja dengan akurasi tinggi.</span> </li>
                            <li class="flex items-start space-x-2"> <span class="text-xl pt-1">🔗</span> <span><strong>Integrasi Marketplace</strong> – Sinkronkan bisnis Anda dengan berbagai marketplace dan payment gateway dalam satu platform.</span> </li>
                            <li class="flex items-start space-x-2"> <span class="text-xl pt-1">📱</span> <span><strong>Akses Fleksibel</strong> – Kelola bisnis dari mana saja dengan aplikasi berbasis cloud yang aman dan cepat.</span> </li>
                        </ul>
                        <button class="w-fit p-3 sm:p-4 bg-[#4F9CF9] text-white rounded-xl text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Coba Sekarang &rarr;</button>
                    @elseif($section['content'] == 'kenapa_fintory')
                        <h1 class="text-3xl sm:text-4xl font-bold">Kenapa harus Fintory?</h1>
                        <p class="text-sm sm:text-base">Dengan Fintory, semua operasional bisnis Anda berjalan otomatis—mulai dari pengelolaan stok, pencatatan transaksi, hingga laporan keuangan. Kurangi pekerjaan manual dan fokus pada pertumbuhan bisnis!</p>
                        <button class="w-fit p-3 sm:p-4 bg-[#4F9CF9] text-white rounded-xl text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Coba Sekarang &rarr;</button>
                    @elseif($section['content'] == 'kelola_bisnis')
                         <h1 class="text-3xl sm:text-4xl font-bold">Kelola bisnis dengan mudah</h1>
                         <p class="text-sm sm:text-base">Gunakan alat terbaik untuk mengelola bisnis Anda secara efisien. Dengan fitur yang dirancang untuk memudahkan pencatatan, analisis, dan pengelolaan keuangan, Anda dapat fokus pada pertumbuhan bisnis tanpa khawatir dengan administrasi yang rumit.</p>
                         <button class="w-fit p-3 sm:p-4 bg-[#4F9CF9] rounded-xl text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Pelajari lebih lanjut &rarr;</button>
                    @elseif($section['content'] == 'otomatisasi_keuangan')
                         <h1 class="text-3xl sm:text-4xl font-bold">Otomatisasi Keuangan dalam Satu Klik</h1>
                         <p class="text-sm sm:text-base">Hilangkan kerepotan pencatatan manual dengan solusi otomatis kami. Dari pelacakan transaksi hingga pembuatan laporan keuangan, semuanya bisa dilakukan dengan mudah dalam satu platform. Tingkatkan efisiensi dan ambil keputusan lebih cerdas dengan data yang akurat.</p>
                         <button class="w-fit p-3 sm:p-4 bg-[#4F9CF9] text-white rounded-xl text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Mulai Sekarang &rarr;</button>
                    @endif
                </div>
                <div class="w-full lg:w-1/2 order-1 {{ $section['order_img'] }}" data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ $section['img'] }}" alt="feature-image" class="w-full h-auto" />
                </div>
            </section>
        </div>
        @endforeach

        <div class="w-full flex justify-center bg-white my-10">
            <section class="max-w-[1480px] flex flex-col w-[95%] items-center justify-between py-12 md:py-20 lg:py-28 text-[#212529] gap-12 md:gap-20 lg:gap-24">
                <div class="w-full my-5 space-y-4 md:space-y-6" data-aos="fade-up">
                    <h1 class="text-center text-3xl sm:text-4xl font-bold">Pilih Paket langganan anda</h1>
                    <p class="text-center text-sm sm:text-base max-w-4xl mx-auto">Kelola bisnis dengan lebih mudah dan efisien menggunakan paket langganan Fintory. Pilih paket yang sesuai dengan kebutuhan Anda, mulai dari operasional dasar hingga otomatisasi penuh. Dengan fitur lengkap untuk manajemen keuangan, inventaris, karyawan, dan pembayaran digital, Fintory membantu bisnis Anda berkembang tanpa batas</p>
                </div>
                <div class="w-full flex flex-col lg:flex-row justify-center items-center lg:items-end gap-6 md:gap-8">
                    {{-- ANIMASI: Menambahkan data-aos dan efek hover pada kartu harga --}}
                    <div data-aos="fade-up" data-aos-delay="100" class="p-6 md:p-8 lg:p-10 border border-[#FFE492] rounded-xl space-y-4 md:space-y-6 w-full lg:w-[31%] transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <h2 class="font-semibold text-xl md:text-2xl">Starter</h2>
                        <h1 class="font-bold text-3xl md:text-4xl">Rp. 79.000,00</h1>
                        <p class="text-base md:text-lg">Untuk semua jenis usaha. Kelola operasional dan penjualan lengkap</p>
                        <ul class="space-y-2 md:space-y-4 text-base md:text-lg">
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Single Outlet </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Toko Online </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Aplikasi Kasir Online </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Manajemen Inventori </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Laporan Lengkap </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Akuntansi Lengkap </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Manajemen Karyawan </li>
                        </ul>
                        <button class="text-base md:text-lg px-6 py-2 md:px-8 md:py-3 border border-[#FFE492] rounded-lg w-full hover:bg-[#FFE492] transition-all duration-300 cursor-pointer">Get Started</button>
                    </div>
                    {{-- ANIMASI: Menambahkan data-aos dan efek hover pada kartu harga "Prime" --}}
                    <div data-aos="fade-up" class="text-white border rounded-xl flex items-center bg-[#043873] w-full lg:w-[38%] transition-all duration-300 hover:shadow-2xl hover:-translate-y-3">
                        <div class="p-6 md:p-8 lg:p-10 space-y-4 md:space-y-6 w-full">
                            <h2 class="font-semibold text-xl md:text-2xl">Prime</h2>
                            <h1 class="font-bold text-3xl md:text-4xl text-[#FFE492]">Rp. 149.000,00</h1>
                            <p class="text-base md:text-lg">Untuk semua jenis usaha. Automasi operasional, penjualan, keuangan, karyawan dan penggajian lengkap</p>
                             <ul class="space-y-2 md:space-y-4 text-base md:text-lg">
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Multi Outlet </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> <div> Toko Online <br> <small class="text-xs"> + Website, Webtree, Weborder, Opsi Premium Domain, Shopee, Tokopedia, Grabmart, Multiakun Marketplace Omnichannel </small> </div> </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Aplikasi Kasir Online </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Manajemen Inventori </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Laporan Lengkap </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Manajemen Keuangan </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> <div> Pencatatan Keuangan <br> <small class="text-xs">Invoice, SO, DO</small> </div> </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Digital Payment </li>
                                 <li class="flex items-start gap-2"> <img src="images/gold-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5 mt-1"> Manajemen Karyawan </li>
                             </ul>
                            <button class="text-base md:text-lg px-6 py-2 md:px-8 md:py-3 bg-[#4F9CF9] rounded-lg w-full hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Get Started</button>
                        </div>
                    </div>
                    {{-- ANIMASI: Menambahkan data-aos dan efek hover pada kartu harga --}}
                    <div data-aos="fade-up" data-aos-delay="200" class="p-6 md:p-8 lg:p-10 border border-[#FFE492] rounded-xl space-y-4 md:space-y-6 w-full lg:w-[31%] transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <h2 class="font-semibold text-xl md:text-2xl">Advanced</h2>
                        <h1 class="font-bold text-3xl md:text-4xl">Rp. 149.000,00</h1>
                        <p class="text-base md:text-lg">Untuk semua jenis usaha. Kelola operasional dan penjualan lengkap</p>
                        <ul class="space-y-2 md:space-y-4 text-base md:text-lg">
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Multi Outlet </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Toko Online </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Aplikasi Kasir Online </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Manajemen Inventori </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Laporan Lengkap </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Akuntansi Lengkap </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Manajemen Karyawan </li>
                            <li class="flex items-center gap-2"> <img src="images/black-pricing-icon.svg" alt="icon" class="w-4 h-4 md:w-5 md:h-5"> Digital Payment </li>
                        </ul>
                        <button class="text-base md:text-lg px-6 py-2 md:px-8 md:py-3 border border-[#FFE492] rounded-lg w-full hover:bg-[#FFE492] transition-all duration-300 cursor-pointer">Get Started</button>
                    </div>
                </div>
            </section>
        </div>

        <div class="w-full bg-[#043873] flex justify-center" style="background-image: url('images/contact-bg.svg'); background-repeat: no-repeat; background-position: left top 90%; background-size: 19%; background-blend-mode: soft-light;">
            <section data-aos="zoom-in" class="max-w-[1480px] flex flex-col w-[95%] items-center justify-center py-12 md:py-20 lg:py-28 text-white gap-4 md:gap-6">
                <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl text-center">Atur keuangan toko darimana saja !</h2>
                <p class="w-full md:w-[80%] text-center text-sm sm:text-base">Kelola bisnis Anda dengan mudah dan praktis bersama Fintory! Semua transaksi tercatat otomatis, laporan keuangan tersusun rapi, dan arus kas selalu terpantau. Akses data keuangan real-time kapan saja dan di mana saja untuk mendapatkan insight mendalam tentang profit, pengeluaran, serta performa toko Anda dalam satu dashboard intuitif. Terhubung dengan berbagai metode pembayaran, termasuk payment gateway dan marketplace, sehingga pencatatan transaksi menjadi lebih efisien. Jangan biarkan pencatatan keuangan yang rumit menghambat bisnis Anda—gunakan Fintory untuk mengoptimalkan keuangan dan memaksimalkan keuntungan!</p>
                <button class="py-3 px-6 md:py-4 md:px-8 bg-[#4F9CF9] rounded-lg text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Try Taskey &rarr;</button>
            </section>
        </div>

        <div class="w-full flex justify-center bg-white">
            <section data-aos="fade-up" class="max-w-[1480px] w-[95%] py-12 md:py-20 lg:py-28 text-[#212529] flex flex-col items-center justify-center gap-12 md:gap-20">
                <h1 class="font-bold text-3xl sm:text-4xl text-center">Fintory telah dipercaya oleh</h1>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 w-full max-w-6xl mx-auto">
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/microsoft.svg" alt="Microsoft" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/apple.svg" alt="Apple" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/instagram.svg" alt="Instagram" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/google.svg" alt="Google" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/amazon.svg" alt="Amazon" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/x.svg" alt="X" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/linkedin.svg" alt="LinkedIn" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                    <div class="flex items-center justify-center"> <img src="images/companies-logo/walmart.svg" alt="Walmart" class="h-12 max-w-[200px] object-contain transition-transform duration-300 ease-in-out hover:scale-105" /> </div>
                </div>
            </section>
        </div>

        <div class="w-full flex justify-center bg-white my-10">
            <section class="max-w-[1480px] flex flex-col w-[95%] items-center justify-between py-12 md:py-20 lg:py-28 text-[#212529] gap-12 md:gap-20 lg:gap-24">
                <div class="w-full my-5 space-y-4 md:space-y-6" data-aos="fade-up">
                    <h1 class="text-center text-3xl sm:text-4xl font-bold">Apa kata mereka ?</h1>
                </div>
                <div class="w-full flex flex-col lg:flex-row justify-center items-center gap-6 md:gap-8">
                    {{-- ANIMASI: Kartu testimoni --}}
                    <div data-aos="fade-up" data-aos-delay="100" class="p-6 md:p-8 lg:p-10 border rounded-xl space-y-4 md:space-y-6 bg-[#4F9CF9] w-full lg:w-1/3 text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <img src="images/quote.svg" alt="quote-icon" class="w-12 h-12" />
                        <p class="pb-4 md:pb-6 text-sm sm:text-base">Gadjian memudahkan saya dalam mengelaborasi data karyawan, mulai dari absensi, cuti, hingga izin, untuk evaluasi yang lebih mendalam.</p>
                        <hr />
                        <div class="pt-4 md:pt-6 pb-2 md:pb-3 flex items-center gap-4">
                            <img src="images/avatar.png" alt="user-avatar" class="rounded-full w-16 h-16" />
                            <div>
                                <h3 class="text-lg font-semibold text-white">Jenny Wilson</h3>
                                <p class="text-sm text-gray-200">Head of Talent Acquisition, North America</p>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200" class="p-6 md:p-8 lg:p-10 border rounded-xl space-y-4 md:space-y-6 bg-[#4F9CF9] w-full lg:w-1/3 text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <img src="images/quote.svg" alt="quote-icon" class="w-12 h-12" />
                        <p class="pb-4 md:pb-6 text-sm sm:text-base">Gadjian memudahkan saya dalam mengelaborasi data karyawan, mulai dari absensi, cuti, hingga izin, untuk evaluasi yang lebih mendalam.</p>
                        <hr />
                        <div class="pt-4 md:pt-6 pb-2 md:pb-3 flex items-center gap-4">
                            <img src="images/avatar.png" alt="user-avatar" class="rounded-full w-16 h-16" />
                            <div>
                                <h3 class="text-lg font-semibold text-white">Jenny Wilson</h3>
                                <p class="text-sm text-gray-200">Head of Talent Acquisition, North America</p>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300" class="p-6 md:p-8 lg:p-10 border rounded-xl space-y-4 md:space-y-6 bg-[#4F9CF9] w-full lg:w-1/3 text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <img src="images/quote.svg" alt="quote-icon" class="w-12 h-12" />
                        <p class="pb-4 md:pb-6 text-sm sm:text-base">Gadjian memudahkan saya dalam mengelaborasi data karyawan, mulai dari absensi, cuti, hingga izin, untuk evaluasi yang lebih mendalam.</p>
                        <hr />
                        <div class="pt-4 md:pt-6 pb-2 md:pb-3 flex items-center gap-4">
                            <img src="images/avatar.png" alt="user-avatar" class="rounded-full w-16 h-16" />
                            <div>
                                <h3 class="text-lg font-semibold text-white">Jenny Wilson</h3>
                                <p class="text-sm text-gray-200">Head of Talent Acquisition, North America</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <div class="w-full bg-[#043873] flex justify-center">
            <section data-aos="fade-up" class="max-w-[1480px] flex flex-col w-[95%] items-center justify-center py-12 md:py-20 lg:py-28 text-white gap-6 md:gap-8 lg:gap-12">
                <h1 class="font-medium text-center text-3xl sm:text-4xl md:text-5xl"> Coba Fintory <br> Sekarang ! </h1>
                <p class="text-center text-sm sm:text-base">Kelola bisnis Anda dengan lebih mudah menggunakan Fintory. Optimalkan produktivitas, tingkatkan efisiensi, dan nikmati solusi digital terbaik untuk manajemen tim serta operasional perusahaan.</p>
                <button class="bg-[#4F9CF9] px-5 py-3 rounded-lg w-fit text-white text-sm sm:text-base hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Coba Gratis 14 Hari &rarr;</button>
                <p class="text-sm sm:text-base">On a big team? Contact Sales</p>
                <div class="flex gap-6 md:gap-8 justify-center">
                    <img src="images/light-apple.svg" alt="apple" class="w-6 h-6 md:w-8 md:h-8 lg:w-10 lg:h-10 transition-transform duration-300 hover:scale-110" />
                    <img src="images/light-windows.svg" alt="windows" class="w-6 h-6 md:w-8 md:h-8 lg:w-10 lg:h-10 transition-transform duration-300 hover:scale-110" />
                    <img src="images/light-android.svg" alt="android" class="w-6 h-6 md:w-8 md:h-8 lg:w-10 lg:h-10 transition-transform duration-300 hover:scale-110" />
                </div>
            </section>
        </div>

        <div class="w-full bg-[#043873] flex justify-center">
             <section class="max-w-[1480px] w-full py-10">
                <div data-aos="fade-up" class="flex flex-col lg:flex-row justify-between gap-8 md:gap-10 mt-8 md:mt-12 w-full text-white px-4">
                    <div class="space-y-2 md:space-y-3 w-full lg:w-[20%]">
                        <img src="{{ asset('images/logo.svg') }}" alt="Fintory Logo" class="h-14 w-auto mb-4" />
                        <p class="text-sm sm:text-base">Aplikasi wirausaha terlengkap untuk kelola bisnismu jadi lebih maju.</p>
                    </div>
                    <div class="space-y-2 md:space-y-3 w-full lg:w-[15%]">
                        <h4 class="font-bold">Fitur</h4>
                        <p class="text-sm sm:text-base">Database Karyawan</p>
                        <p class="text-sm sm:text-base">Organisasi</p>
                        <p class="text-sm sm:text-base">Manajemen Aset Kantor</p>
                    </div>
                    <div class="space-y-2 md:space-y-3 w-full lg:w-[15%]">
                        <h4 class="font-bold">Tentang Kami</h4>
                        <p class="text-sm sm:text-base">Blog</p>
                        <p class="text-sm sm:text-base">Syarat & Ketentuan</p>
                        <p class="text-sm sm:text-base">Kebijakan & Privasi</p>
                    </div>
                    <div class="space-y-2 md:space-y-3 w-full lg:w-[25%]">
                        <h4 class="font-bold">Hubungi Kami</h4>
                        <div class="flex gap-2 md:gap-3 items-center">
                            <img src="images/send-icon.svg" alt="send" class="w-3 h-3 md:w-4 md:h-4" />
                            <p class="text-sm sm:text-base">Kirim Pesan</p>
                        </div>
                        <div class="flex gap-2 md:gap-3 items-center">
                            <img src="images/telephone-icon.svg" alt="telephone" class="w-3 h-3 md:w-4 md:h-4" />
                            <p class="text-sm sm:text-base">021-1111-1111</p>
                        </div>
                        <div class="flex gap-2 md:gap-3 items-center">
                            <img src="images/location-icon.svg" alt="location" class="w-3 h-3 md:w-4 md:h-4" />
                            <p class="text-sm sm:text-base">Jl. Pendidikan No.15, Cibiru Wetan, 1500</p>
                        </div>
                    </div>
                    <div class="space-y-2 md:space-y-3 w-full lg:w-[20%]">
                        <h4 class="font-bold">Coba Sekarang</h4>
                        <p class="text-sm sm:text-base">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                        <button class="bg-[#4F9CF9] text-white px-5 py-3 rounded-lg text-sm sm:text-base w-fit hover:brightness-90 transition-all duration-300 cursor-pointer hover:-translate-y-1">Coba Sekarang &rarr;</button>
                    </div>
                </div>
            </section>
        </div>

        <div class="w-full bg-[#043873] border-t border-[#2E4E73] flex justify-center">
            <footer class="max-w-[1480px] py-6 md:py-8 flex flex-col md:flex-row w-[95%] items-center justify-between text-white gap-4 md:gap-12">
                <div class="flex flex-col md:flex-row gap-4 md:gap-6 lg:gap-12 text-sm sm:text-base">
                    <p class="flex gap-2 items-center"><i class="fa-solid fa-globe"></i> Indonesia <i class="fa-solid fa-chevron-down"></i></p>
                    <p>Syarat & Ketentuan</p>
                    <p>Kebijakan Privasi</p>
                    <p>Status</p>
                    <p>&copy;2025 Fintory Company</p>
                </div>
                <div class="flex gap-6 md:gap-12">
                    <i class="fa-brands fa-facebook-f text-xl md:text-2xl transition-transform duration-300 hover:scale-125"></i>
                    <i class="fa-brands fa-twitter text-xl md:text-2xl transition-transform duration-300 hover:scale-125"></i>
                    <i class="fa-brands fa-linkedin-in text-xl md:text-2xl transition-transform duration-300 hover:scale-125"></i>
                </div>
            </footer>
        </div>
    </main>
</body>

</html>