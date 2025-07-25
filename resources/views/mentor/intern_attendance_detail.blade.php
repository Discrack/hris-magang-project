<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Presensi {{ $intern->full_name }} - Mentor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-purple-600 p-4 text-white flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <a href="{{ route('mentor.attendance') }}" class="text-white hover:text-purple-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Detail Presensi Peserta Magang</h1>
        </div>
        <div class="flex items-center">
            <span class="mr-4">Selamat datang, {{ Auth::user()->username }}!</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Detail Presensi: {{ $intern->full_name }}</h2>
            <p class="text-lg text-gray-600 mb-4">Email: {{ $intern->email }}</p>
            <p class="text-lg text-gray-600 mb-4">Mentor: {{ $intern->mentor->full_name ?? 'Belum Ditentukan' }}</p>

            <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-6">Riwayat Presensi</h3>
            @if ($attendanceHistory->isEmpty())
                <p class="text-center text-gray-600">Belum ada riwayat presensi untuk peserta magang ini.</p>
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