<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-purple-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">HRIS Magang - Mentor Dashboard</h1>
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
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Mentor</h2>
        @if($mentor)
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <p class="text-lg mb-2"><strong>Nama Lengkap:</strong> {{ $mentor->full_name }}</p>
                <p class="text-lg mb-2"><strong>Email:</strong> {{ $mentor->email }}</p>
                <p class="text-lg mb-2"><strong>Departemen:</strong> {{ $mentor->department ?? '-' }}</p>
                <p class="text-lg mb-2"><strong>Total Peserta Bimbingan:</strong> {{ $mentor->interns->count() }}</p>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Informasi Profil Belum Lengkap</p>
                <p>Silakan hubungi admin untuk melengkapi data profil Anda.</p>
            </div>
        @endif

        <div class="mt-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('mentor.assessments.create') }}"
                    class="block bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Nilai Peserta Magang
                </a>
                <a href="{{ route('mentor.attendance') }}"
                    class="block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    Lihat Presensi Bimbingan
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

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Peserta Magang Bimbingan Anda</h3>
            @if ($bimbinganInterns->isEmpty())
                <p class="text-center text-gray-600">Tidak ada peserta magang yang dibimbing oleh Anda.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nama Lengkap</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($bimbinganInterns as $intern)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $intern->full_name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $intern->email }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <a href="{{ route('mentor.interns.profile.show', $intern->intern_id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded-lg text-xs transition duration-300">
                                            Lihat Profil
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>

</html>