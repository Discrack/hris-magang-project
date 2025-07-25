<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penilaian & Feedback - Admin</title>
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
            <a href="{{ route('admin.assessments.index') }}" class="text-white hover:text-blue-200 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold">Edit Penilaian & Feedback</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Form Edit Penilaian & Feedback</h2>

            <form action="{{ route('admin.assessments.update', $assessment->assessment_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="intern_id" class="block text-gray-700 text-sm font-semibold mb-2">Peserta
                        Magang:</label>
                    <select name="intern_id" id="intern_id"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        @foreach ($interns as $intern)
                        <option value="{{ $intern->intern_id }}"
                            {{ old('intern_id', $assessment->intern_id) == $intern->intern_id ? 'selected' : '' }}>
                            {{ $intern->full_name }} ({{ $intern->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('intern_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="mentor_id" class="block text-gray-700 text-sm font-semibold mb-2">Mentor:</label>
                    <select name="mentor_id" id="mentor_id"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        @foreach ($mentors as $mentor)
                        <option value="{{ $mentor->mentor_id }}"
                            {{ old('mentor_id', $assessment->mentor_id) == $mentor->mentor_id ? 'selected' : '' }}>
                            {{ $mentor->full_name }} ({{ $mentor->department ?? 'N/A' }})
                        </option>
                        @endforeach
                    </select>
                    @error('mentor_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 text-sm font-semibold mb-2">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('rating', $assessment->rating) }}" required>
                    @error('rating')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="feedback" class="block text-gray-700 text-sm font-semibold mb-2">Feedback
                        (Opsional):</label>
                    <textarea id="feedback" name="feedback" rows="6"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('feedback', $assessment->feedback) }}</textarea>
                    @error('feedback')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="assessment_date" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal
                        Penilaian:</label>
                    <input type="date" id="assessment_date" name="assessment_date"
                        class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('assessment_date', \Carbon\Carbon::parse($assessment->assessment_date)->format('Y-m-d')) }}"
                        required>
                    @error('assessment_date')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">
                        Perbarui Penilaian
                    </button>
                    <a href="{{ route('admin.assessments.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>