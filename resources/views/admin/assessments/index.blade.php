<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Penilaian & Feedback - Admin</title>
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
            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Manajemen Penilaian & Feedback</h1>
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
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Penilaian & Feedback</h2>

            @if ($assessments->isEmpty())
                <p class="text-center text-gray-600">Belum ada penilaian atau feedback yang tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Tanggal Penilaian</th>
                                <th class="py-3 px-6 text-left">Peserta Magang</th>
                                <th class="py-3 px-6 text-left">Mentor</th>
                                <th class="py-3 px-6 text-left">Rating</th>
                                <th class="py-3 px-6 text-left">Feedback</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($assessments as $assessment)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($assessment->assessment_date)->format('d F Y') }}
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $assessment->intern->full_name ?? 'N/A' }}</td>
                                    <td class="py-3 px-6 text-left">{{ $assessment->mentor->full_name ?? 'N/A' }}</td>
                                    <td class="py-3 px-6 text-left">{{ $assessment->rating }} / 5</td>
                                    <td class="py-3 px-6 text-left">{{ Str::limit($assessment->feedback, 70) ?? '-' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-2">
                                            <a href="{{ route('admin.assessments.edit', $assessment->assessment_id) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-lg text-xs transition duration-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.assessments.destroy', $assessment->assessment_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg text-xs transition duration-300">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
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