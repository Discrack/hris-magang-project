<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-green-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">HRIS Magang - Intern Dashboard</h1>
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
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Profil Peserta Magang</h2>
        @if($intern)
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <p class="text-lg mb-2"><strong>Nama Lengkap:</strong> {{ $intern->full_name }}</p>
                <p class="text-lg mb-2"><strong>Email:</strong> {{ $intern->email }}</p>
                <p class="text-lg mb-2"><strong>Nomor Telepon:</strong> {{ $intern->phone_number ?? '-' }}</p>
                <p class="text-lg mb-2"><strong>Batch Magang:</strong> {{ $intern->batch ?? '-' }}</p>
                <p class="text-lg mb-2"><strong>Tanggal Bergabung:</strong> {{ $intern->joining_date }}</p>
                <p class="text-lg mb-2"><strong>Mentor:</strong> {{ $intern->mentor->full_name ?? 'Belum Ditentukan' }}</p>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Informasi Profil Belum Lengkap</p>
                <p>Silakan hubungi admin untuk melengkapi data profil Anda.</p>
            </div>
        @endif

        <div class="mt-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('intern.attendance') }}"
                    class="block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Catat Presensi
                </a>
                <a href="{{ route('intern.payroll') }}"
                    class="block bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Lihat Gaji
                </a>
                <a href="{{ route('intern.profile.show') }}"
                    class="block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Lihat Profil
                </a>
                <a href="{{ route('intern.assessments.index') }}"
                    class="block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Lihat Penilaian
                </a>
                <a href="{{ route('general.program_info.index') }}"
                    class="block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Informasi Program
                </a>
                <a href="{{ route('general.calendar.index') }}"
                    class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Kalender Program
                </a>
            </div>
        </div>
</body>

</html>