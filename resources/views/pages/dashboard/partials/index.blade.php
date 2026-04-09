<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSpeed Motoshop</title>

    <!-- Tailwind -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font (mirip desain modern tech) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .heading {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0A0F1C] text-white">

    <!-- ================= NAVBAR ================= -->
    <header class="fixed top-0 w-full z-50 bg-[#0A0F1C]/80 backdrop-blur border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-2 font-semibold tracking-wide">
                <span class="text-yellow-400 text-xl">⚡</span>
                <span class="text-gray-200">
                    XSPEED <span class="text-yellow-400 font-bold">MOTOSHOP</span>
                </span>
            </div>

            <!-- Menu -->
            <nav class="hidden md:flex gap-8 text-sm text-gray-400">
                <a href="#" class="hover:text-white">Home</a>
                <a href="#" class="hover:text-white">Products</a>
                <a href="#" class="hover:text-white">Gallery</a>
                <a href="#" class="hover:text-white">Testimonials</a>
                <a href="#" class="hover:text-white">About</a>
                <a href="#" class="hover:text-white">Contact</a>
            </nav>

            <!-- Admin -->
            <a href="#"
                class="hidden md:inline-block bg-yellow-400 text-black px-4 py-2 rounded-lg text-sm font-semibold">
                Admin
            </a>

            <!-- Mobile -->
            <button id="menuBtn" class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <!-- ================= HERO ================= -->
    <section class="relative min-h-screen flex items-center">

        <!-- Background -->
        <div class="absolute inset-0">
            <img src="{{ asset('build/assets/dashboard/assets/img/hero-bg.jpg') }}"
                class="w-full h-full object-cover opacity-40 blur-sm" alt="Background Image">

            <!-- overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0A0F1C] via-[#0A0F1C]/95 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-6 w-full">
            <div class="max-w-2xl">

                <!-- Badge -->
                <div
                    class="inline-block mb-6 px-4 py-1 text-xs font-medium 
                        text-yellow-400 border border-yellow-400/30 rounded-full">
                    Premium Motorcycle Parts
                </div>

                <!-- Title -->
                <h1 class="heading text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight">
                    <span class="text-gray-200">Upgrade Your</span><br>
                    <span class="text-yellow-400">Ride Performance</span>
                </h1>

                <!-- Description -->
                <p class="mt-6 text-gray-400 text-sm sm:text-base leading-relaxed max-w-md">
                    High-quality spare parts for all motorcycle brands. Trusted
                    by thousands of riders across Indonesia.
                </p>

                <!-- Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">

                    <a href="#"
                        class="inline-flex items-center justify-center gap-2 
                          bg-yellow-400 text-black px-6 py-3 rounded-lg 
                          font-semibold hover:bg-yellow-300 transition">

                        Shop Now
                        <span>→</span>
                    </a>

                    <a href="#"
                        class="inline-flex items-center justify-center 
                          border border-white/10 text-gray-300 px-6 py-3 
                          rounded-lg hover:bg-white/5 transition">
                        Learn More
                    </a>
                </div>

                <!-- Features -->
                <div class="mt-10 flex flex-col sm:flex-row gap-6 text-sm text-gray-400">

                    <div class="flex items-center gap-2">
                        <span class="text-yellow-400">✔</span>
                        <span>Genuine Parts</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-yellow-400">✔</span>
                        <span>Fast Delivery</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-yellow-400">✔</span>
                        <span>Expert Support</span>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Script Mobile -->
    <script>
        const btn = document.getElementById('menuBtn');
        btn?.addEventListener('click', () => {
            alert('Menu mobile bisa kamu lanjutkan (drawer/dropdown)');
        });
    </script>

</body>

</html>
