<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Peserta Magang: {{ $intern->full_name }} - Mentor</title>
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
            <a href="{{ route('mentor.dashboard') }}" class="text-white hover:text-purple-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Profil Peserta Magang</h1>
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
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Detail Profil: {{ $intern->full_name }}</h2>

            <div class="mb-6">
                <img src="{{ $intern->profile_picture_url }}" alt="Foto Profil"
                    class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-purple-300 shadow-lg">
            </div>

            <div class="text-left max-w-lg mx-auto">
                <p class="text-lg mb-2"><strong>Nama Lengkap:</strong> {{ $intern->full_name }}</p>
                <p class="text-lg mb-2"><strong>Username:</strong> {{ $intern->user->username ?? '-' }}</p>
                <p class="text-lg mb-2"><strong>Email:</strong> {{ $intern->email }}</p>
                <p class="text-lg mb-2"><strong>Nomor Telepon:</strong> {{ $intern->phone_number ?? '-' }}</p>
                <p class="text-lg mb-2"><strong>Batch Magang:</strong> {{ $intern->batch ?? '-' }}</p>
                {{-- <p class="text-lg mb-2"><strong>Asal Kampus:</strong> {{ $intern->asal_kampus ?? '-' }}</p> --}}
                <p class="text-lg mb-2"><strong>Mentor Pembimbing:</strong>
                    {{ $intern->mentor->full_name ?? 'Belum Ditentukan' }}</p>
                <p class="text-lg mb-2"><strong>Tanggal Bergabung:</strong>
                    {{ \Carbon\Carbon::parse($intern->joining_date)->format('d F Y') }}</p>
                <p class="text-lg mb-2"><strong>Tanggal Berakhir:</strong>
                    {{ $intern->termination_date ? \Carbon\Carbon::parse($intern->termination_date)->format('d F Y') : '-' }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>