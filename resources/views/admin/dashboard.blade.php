<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">HRIS Magang - Admin Dashboard</h1>
        <div class="flex items-center">
            <span class="mr-4">Selamat datang, {{ $user->username }} ({{ $user->role }})!</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Admin</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-3">Total Peserta Magang</h3>
                <p class="text-4xl font-bold text-blue-600">15 (masi dummy)</p>
                <p class="text-gray-500 mt-2">Peserta aktif saat ini</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-3">Presensi Hari Ini</h3>
                <p class="text-4xl font-bold text-green-600">95% (masi dummy)</p>
                <p class="text-gray-500 mt-2">Rata-rata kehadiran</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-3">Feedback Terbaru</h3>
                <p class="text-lg font-bold text-purple-600">5 Feedback Baru (masi dummy)</p>
                <p class="text-gray-500 mt-2">Perlu ditindaklanjuti</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.attendance') }}"
                    class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kelola Presensi
                </a>
                <a href="{{ route('admin.payroll.index') }}"
                    class="block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kelola Gaji
                </a>
                <a href="{{ route('admin.interns.index') }}"
                    class="block bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kelola Profil
                </a>
                <a href="{{ route('admin.program_info.index') }}"
                    class="block bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Informasi Program
                </a>
                <a href="{{ route('admin.calendar.index') }}"
                    class="block bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kalender Program
                </a>
                <a href="{{ route('admin.assessments.index') }}"
                    class="block bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kelola Penilaian
                </a>
            </div>
        </div>
    </div>
</body>

</html>