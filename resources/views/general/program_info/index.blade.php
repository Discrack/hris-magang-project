<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Program Magang</title>
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
            {{-- Tombol kembali dinamis berdasarkan peran --}}
            @if(Auth::check())
                @php
                    $user = Auth::user();
                    $backRoute = '';
                    if ($user->role === 'admin') {
                        $backRoute = route('admin.dashboard');
                    } elseif ($user->role === 'intern') {
                        $backRoute = route('intern.dashboard');
                    } elseif ($user->role === 'mentor') {
                        $backRoute = route('mentor.dashboard');
                    }
                @endphp
                <a href="{{ $backRoute }}" class="text-white hover:text-blue-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            @endif
            <h1 class="text-2xl font-bold">Informasi Program Magang</h1>
        </div>
        <div class="flex items-center">
            @if(Auth::check())
                <span class="mr-4">Selamat datang, {{ Auth::user()->username }}!</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">Logout</button>
                </form>
            @endif
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Pengumuman & Informasi Penting</h2>

            @if ($programInfos->isEmpty())
                <p class="text-center text-gray-600">Belum ada informasi program yang dipublikasikan.</p>
            @else
                <div class="space-y-6">
                    @foreach ($programInfos as $info)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $info->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4">Dipublikasikan:
                                {{ \Carbon\Carbon::parse($info->created_at)->format('d F Y H:i') }}
                            </p>
                            <p class="text-gray-700 leading-relaxed">{{ $info->content }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>

</html>