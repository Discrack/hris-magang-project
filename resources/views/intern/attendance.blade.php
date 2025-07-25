<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Absensi Peserta Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <a href="{{ route('intern.dashboard') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Presensi Absensi</h1>
        </div>
        <div class="flex items-center">
            <span class="mr-4">Selamat datang, {{ $user->username }}!</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Status Presensi Hari Ini</h2>
            <p class="text-xl text-center mb-4">Tanggal: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>

            @if ($todayAttendance)
                <div class="text-center mb-4">
                    <p class="text-lg">Check-in: <span
                            class="font-semibold">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</span>
                    </p>
                    @if ($todayAttendance->check_out_time)
                        <p class="text-lg">Check-out: <span
                                class="font-semibold">{{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i:s') }}</span>
                        </p>
                        <p class="text-green-600 font-bold mt-2">Anda sudah selesai presensi hari ini.</p>
                    @else
                        <p class="text-red-600 font-bold mt-2">Anda sudah check-in. Silakan check-out saat pulang.</p>
                        <form action="{{ route('intern.checkout') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                                Check-out
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <p class="text-lg text-gray-600 mb-4">Anda belum check-in hari ini.</p>
                    <form action="{{ route('intern.checkin') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Check-in Sekarang
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Riwayat Presensi Terbaru</h2>
            @if ($attendanceHistory->isEmpty())
                <p class="text-center text-gray-600">Belum ada riwayat presensi.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Check-in</th>
                                <th class="py-3 px-6 text-left">Check-out</th>
                                <th class="py-3 px-6 text-left">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($attendanceHistory as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($record->attendance_date)->format('d F Y') }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ \Carbon\Carbon::parse($record->check_in_time)->format('H:i:s') }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        @if ($record->check_out_time)
                                            {{ \Carbon\Carbon::parse($record->check_out_time)->format('H:i:s') }}
                                        @else
                                            <span class="text-red-500">Belum Check-out</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $record->notes ?? '-' }}</td>
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