<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NearFlight - Pesan Tiket Pesawat dengan Mudah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .flight-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .flight-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">✈</span>
                    </div>
                    <span class="font-bold text-xl hidden sm:inline">NearFlight</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#flights" class="text-gray-600 hover:text-gray-900 font-medium hidden sm:inline">Penerbangan</a>
                    <a href="#destinations" class="text-gray-600 hover:text-gray-900 font-medium hidden sm:inline">Destinasi</a>
                    <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-5xl sm:text-6xl font-bold mb-4">Terbang Lebih Dekat</h1>
                <p class="text-xl sm:text-2xl text-gray-100 mb-8">Temukan penerbangan terbaik dengan harga terjangkau</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-2xl p-8 max-w-4xl mx-auto">
                <form class="space-y-6" action="" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Trip Type -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-3">Tipe Perjalanan</label>
                            <div class="flex gap-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="trip_type" value="round" checked class="w-4 h-4">
                                    <span class="ml-2 text-gray-700">Pulang Pergi</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="trip_type" value="one_way" class="w-4 h-4">
                                    <span class="ml-2 text-gray-700">Sekali Jalan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Passenger Count -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-3">Penumpang</label>
                            <select name="passengers" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ $i === 1 ? 'selected' : '' }}>{{ $i }} Penumpang</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- From -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Dari</label>
                            <input type="text" name="from" placeholder="Bandara keberangkatan" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- To -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Ke</label>
                            <input type="text" name="to" placeholder="Bandara tujuan" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Keberangkatan</label>
                            <input type="date" name="departure_date" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <!-- Return Date (shown for round trip) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div id="return-date-container" class="hidden">
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Kembali</label>
                            <input type="date" name="return_date" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transition text-lg">
                        Cari Penerbangan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="bg-gray-50 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($stats['passengers'] / 1000) }}K+</div>
                    <p class="text-gray-600">Penumpang Senang</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ $stats['routes'] }}+</div>
                    <p class="text-gray-600">Rute Tersedia</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['flights_daily'] }}+</div>
                    <p class="text-gray-600">Penerbangan Harian</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-600 mb-2">{{ $stats['airlines'] }}+</div>
                    <p class="text-gray-600">Maskapai Partner</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12">Mengapa Memilih NearFlight?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">💰</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Harga Terbaik</h3>
                    <p class="text-gray-600">Kami menjamin harga penerbangan termurah dengan transparansi penuh tanpa biaya tersembunyi.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🔒</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Aman & Terpercaya</h3>
                    <p class="text-gray-600">Transaksi Anda dilindungi dengan enkripsi tingkat bank dan sistem keamanan terkini.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Booking Cepat</h3>
                    <p class="text-gray-600">Proses pemesanan yang sederhana dan cepat hanya dalam beberapa klik saja.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">📱</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Aplikasi Mobile</h3>
                    <p class="text-gray-600">Download aplikasi kami untuk pesan tiket dimana saja, kapan saja dengan mudah.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🎁</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Poin Loyalitas</h3>
                    <p class="text-gray-600">Setiap pemesanan memberikan poin yang dapat ditukar dengan diskon atau hadiah menarik.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white rounded-lg p-8 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Dukungan 24/7</h3>
                    <p class="text-gray-600">Tim customer service kami siap membantu Anda kapan saja untuk segala pertanyaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Flights Section -->
    @if ($popularFlights->isNotEmpty())
    <section id="flights" class="bg-gray-50 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold mb-12">Penerbangan Populer</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($popularFlights as $flight)
                <div class="flight-card bg-white">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $flight->airline->name ?? 'Airlines' }}</p>
                                <p class="text-sm text-gray-500">{{ $flight->flight_number ?? 'FLxx' }}</p>
                            </div>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                                Populer
                            </span>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-gray-900">{{ substr($flight->departure_airport, 0, 3) ?? 'CGK' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $flight->departure_time?->format('H:i') ?? '08:00' }}</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                <div class="flex-grow h-px bg-gray-300 mx-2"></div>
                                <span class="text-gray-400">{{ $flight->duration ?? '2h 30m' }}</span>
                                <div class="flex-grow h-px bg-gray-300 mx-2"></div>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-gray-900">{{ substr($flight->arrival_airport, 0, 3) ?? 'DPS' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $flight->arrival_time?->format('H:i') ?? '11:30' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($flight->price ?? 500000, 0, ',', '.') }}</span>
                                <p class="text-xs text-gray-500">/penumpang</p>
                            </div>
                            <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-semibold">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Popular Destinations Section -->
    <section id="destinations" class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold mb-12">Destinasi Populer</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg p-6 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <p class="text-3xl mb-2">✈️</p>
                    <p class="font-bold text-lg">Jakarta (CGK)</p>
                    <p class="text-blue-100 text-sm">9,500+ Penerbangan</p>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg p-6 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <p class="text-3xl mb-2">🏝️</p>
                    <p class="font-bold text-lg">Denpasar (DPS)</p>
                    <p class="text-green-100 text-sm">7,200+ Penerbangan</p>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg p-6 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <p class="text-3xl mb-2">🌆</p>
                    <p class="font-bold text-lg">Surabaya (SUB)</p>
                    <p class="text-orange-100 text-sm">5,800+ Penerbangan</p>
                </div>
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg p-6 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <p class="text-3xl mb-2">🏙️</p>
                    <p class="font-bold text-lg">Medan (KNO)</p>
                    <p class="text-purple-100 text-sm">4,300+ Penerbangan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="hero-gradient text-white py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Siap Terbang?</h2>
            <p class="text-xl mb-8">Dapatkan diskon hingga 30% untuk penerbangan Anda sekarang juga!</p>
            <button class="bg-white text-blue-600 font-bold px-8 py-3 rounded-lg hover:shadow-lg transition text-lg">
                Booking Sekarang
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white mb-4 flex items-center space-x-2">
                        <span class="text-2xl">✈️</span>
                        <span>NearFlight</span>
                    </h3>
                    <p class="text-sm">Platform pemesanan tiket pesawat terpercaya di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Penerbangan</a></li>
                        <li><a href="#" class="hover:text-white">Hotel</a></li>
                        <li><a href="#" class="hover:text-white">Paket Liburan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <p class="text-center text-sm">© 2026 NearFlight. Semua hak dilindungi. | Made with ❤️ for Indonesia</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle return date visibility based on trip type
        const tripTypeRadios = document.querySelectorAll('input[name="trip_type"]');
        const returnDateContainer = document.getElementById('return-date-container');

        tripTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'round') {
                    returnDateContainer.classList.remove('hidden');
                } else {
                    returnDateContainer.classList.add('hidden');
                }
            });
        });

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="departure_date"]').setAttribute('min', today);
        document.querySelector('input[name="return_date"]').setAttribute('min', today);
    </script>
</body>
</html>
