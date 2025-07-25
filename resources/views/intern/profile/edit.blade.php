<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Saya - Peserta Magang</title>
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
            <a href="{{ route('intern.profile.show') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Edit Profil Saya</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Profil Anda</h2>

            <form action="{{ route('intern.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4 text-center">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Foto Profil:</label>
                    <img src="{{ $intern->profile_picture_url }}" alt="Foto Profil"
                        class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-300 shadow-lg mb-4">

                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('profile_picture')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG, GIF, SVG. Max ukuran: 2MB. Unggah untuk
                        mengubah.</p>

                    @if ($intern->profile_picture)
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" name="remove_profile_picture" value="1"
                                class="form-checkbox h-4 w-4 text-red-600">
                            <span class="ml-2 text-sm text-gray-700">Hapus foto profil</span>
                        </label>
                    @endif
                </div>

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
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                    <input type="email" id="email" name="email"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('email', $intern->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
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

                {{-- Hapus Tambahan: Asal Kampus --}}
                {{--
                <div class="mb-4">
                    <label for="asal_kampus" class="block text-gray-700 text-sm font-semibold mb-2">Asal Kampus
                        (Opsional):</label>
                    <input type="text" id="asal_kampus" name="asal_kampus"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('asal_kampus', $intern->asal_kampus) }}">
                    @error('asal_kampus')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                --}}

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password Baru
                        (kosongkan jika
                        tidak diubah):</label>
                    <input type="password" id="password" name="password"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi
                        Password Baru:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex items-center justify-center space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                        Perbarui Profil
                    </button>
                    <a href="{{ route('intern.profile.show') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>