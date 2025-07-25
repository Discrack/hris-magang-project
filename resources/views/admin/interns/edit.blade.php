<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta Magang - Admin</title>
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
            <a href="{{ route('admin.interns.index') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Edit Peserta Magang</h1>
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
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Profil Peserta Magang:
                {{ $intern->full_name }}</h2>

            <form action="{{ route('admin.interns.update', $intern->intern_id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="full_name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap:</label>
                    <input type="text" id="full_name" name="full_name"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('full_name', $intern->full_name) }}" required>
                    @error('full_name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username Login:</label>
                    <input type="text" id="username" name="username"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('username', $intern->user->username) }}" required>
                    @error('username')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password Baru
                        (kosongkan jika tidak diubah):</label>
                    <input type="password" id="password" name="password"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                    <input type="email" id="email" name="email"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('email', $intern->email) }}" required>
                    @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian untuk Foto Profil -->
                <div class="mb-4">
                    <label for="profile_picture" class="block text-gray-700 text-sm font-semibold mb-2">Foto Profil
                        (Opsional):</label>
                    @if ($intern->profile_picture)
                    <div class="mb-2">
                        <img src="{{ $intern->profile_picture_url }}" alt="Foto Profil"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300">
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" name="remove_profile_picture" value="1"
                                class="form-checkbox h-4 w-4 text-red-600">
                            <span class="ml-2 text-sm text-gray-700">Hapus foto profil</span>
                        </label>
                    </div>
                    @else
                    <div class="mb-2">
                        <img src="{{ $intern->profile_picture_url }}" alt="Avatar Dummy"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300">
                        <p class="text-gray-500 text-sm mt-1">Belum ada foto profil. Akan menggunakan avatar *dummy*.
                        </p>
                    </div>
                    @endif
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('profile_picture')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG, GIF, SVG. Max ukuran: 2MB. Unggah untuk
                        mengubah.</p>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-semibold mb-2">Nomor Telepon
                        (Opsional):</label>
                    <input type="text" id="phone_number" name="phone_number"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('phone_number', $intern->phone_number) }}">
                    @error('phone_number')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="batch" class="block text-gray-700 text-sm font-semibold mb-2">Batch Magang
                        (Opsional):</label>
                    <input type="text" id="batch" name="batch"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('batch', $intern->batch) }}">
                    @error('batch')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hapus Tambahan: Asal Kampus --}}
                {{--
                <div class="mb-4">
                    <label for="asal_kampus" class="block text-gray-700 text-sm font-semibold mb-2">Asal Kampus (Opsional):</label>
                    <input type="text" id="asal_kampus" name="asal_kampus" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('asal_kampus', $intern->asal_kampus) }}">
                @error('asal_kampus')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
        </div>
        --}}

        <div class="mb-4">
            <label for="mentor_id" class="block text-gray-700 text-sm font-semibold mb-2">Mentor Pembimbing
                (Opsional):</label>
            <select name="mentor_id" id="mentor_id"
                class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih Mentor</option>
                @foreach ($mentors as $mentor)
                <option value="{{ $mentor->mentor_id }}"
                    {{ old('mentor_id', $intern->mentor_id) == $mentor->mentor_id ? 'selected' : '' }}>
                    {{ $mentor->full_name }} ({{ $mentor->department ?? 'N/A' }})
                </option>
                @endforeach
            </select>
            @error('mentor_id')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="joining_date" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Bergabung:</label>
            <input type="date" id="joining_date" name="joining_date"
                class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                value="{{ old('joining_date', \Carbon\Carbon::parse($intern->joining_date)->format('Y-m-d')) }}"
                required>
            @error('joining_date')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="termination_date" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Berakhir
                (Opsional):</label>
            <input type="date" id="termination_date" name="termination_date"
                class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                value="{{ old('termination_date', $intern->termination_date ? \Carbon\Carbon::parse($intern->termination_date)->format('Y-m-d') : '') }}">
            @error('termination_date')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center space-x-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                Perbarui Profil
            </button>
            <a href="{{ route('admin.interns.index') }}"
                class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Batal
            </a>
        </div>
        </form>
    </div>
    </div>
</body>

</html>