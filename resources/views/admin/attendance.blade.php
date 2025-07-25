<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Presensi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Style untuk tanggal yang dipilih */
        input[type="date"] {
            padding: 8px 12px;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background-color: #fff;
            color: #374151;
            font-size: 1rem;
            line-height: 1.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        input[type="date"]:focus {
            outline: none;
            border-color: #3b82f6;
            /* blue-500 */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
            /* blue-500 with opacity */
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Manajemen Presensi</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Data Presensi Peserta Magang</h2>

            <div class="mb-6 flex justify-center items-center">
                <label for="attendance_date" class="block text-gray-700 text-sm font-semibold mr-3">Pilih
                    Tanggal:</label>
                <input type="date" id="attendance_date" name="attendance_date" class="form-input"
                    value="{{ $selectedDate }}"
                    onchange="window.location.href = '{{ route('admin.attendance') }}?date=' + this.value;">
            </div>

            <p class="text-xl text-center mb-4">Presensi pada: <span
                    class="font-semibold">{{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</span></p>

            @if ($interns->isEmpty())
                <p class="text-center text-gray-600">Tidak ada peserta magang yang ditemukan atau data presensi untuk
                    tanggal ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nama Peserta Magang</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">Check-in</th>
                                <th class="py-3 px-6 text-left">Check-out</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($interns as $intern)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $intern->full_name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $intern->email }}</td>
                                    <td class="py-3 px-6 text-left">
                                        @if ($intern->attendances->first())
                                            {{ \Carbon\Carbon::parse($intern->attendances->first()->check_in_time)->format('H:i:s') }}
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        @if ($intern->attendances->first() && $intern->attendances->first()->check_out_time)
                                            {{ \Carbon\Carbon::parse($intern->attendances->first()->check_out_time)->format('H:i:s') }}
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($intern->attendances->isEmpty())
                                            <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Absen</span>
                                        @else
                                            @if ($intern->attendances->first()->check_out_time)
                                                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Selesai</span>
                                            @else
                                                <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Hadir (Belum
                                                    Checkout)</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <a href="{{ route('admin.attendance.show', $intern->intern_id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded-lg text-xs transition duration-300">
                                            Detail
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