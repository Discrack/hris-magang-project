<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class InternProfileController extends Controller
{
    /**
     * Tampilkan daftar semua peserta magang (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $interns = Intern::with('user', 'mentor')->orderBy('full_name')->get();
        return view('admin.interns.index', compact('interns'));
    }

    /**
     * Tampilkan form untuk membuat peserta magang baru (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $mentors = Mentor::all();
        return view('admin.interns.create', compact('mentors'));
    }

    /**
     * Simpan peserta magang baru ke database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:interns,email',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'batch' => 'nullable|string|max:50',
            'asal_kampus' => 'nullable|string|max:100', // Tambahkan validasi ini
            'mentor_id' => 'nullable|exists:mentors,mentor_id',
            'joining_date' => 'required|date',
            'termination_date' => 'nullable|date|after_or_equal:joining_date',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'intern',
        ]);

        $profilePictureName = null;
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $profilePictureName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/avatars', $profilePictureName);
        }

        Intern::create([
            'user_id' => $user->user_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'profile_picture' => $profilePictureName,
            'phone_number' => $request->phone_number,
            'batch' => $request->batch,
            'asal_kampus' => $request->asal_kampus, // Simpan data ini
            'mentor_id' => $request->mentor_id,
            'joining_date' => $request->joining_date,
            'termination_date' => $request->termination_date,
        ]);

        return redirect()->route('admin.interns.index')->with('success', 'Peserta magang berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit peserta magang (Admin).
     *
     * @param  int  $internId
     * @return \Illuminate\View\View
     */
    public function edit($internId)
    {
        $intern = Intern::with('user')->findOrFail($internId);
        $mentors = Mentor::all();
        return view('admin.interns.edit', compact('intern', 'mentors'));
    }

    /**
     * Perbarui data peserta magang di database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $internId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $internId)
    {
        $intern = Intern::with('user')->findOrFail($internId);

        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($intern->user->user_id, 'user_id'),
            ],
            'password' => 'nullable|string|min:8',
            'full_name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('interns', 'email')->ignore($intern->intern_id, 'intern_id'),
            ],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'batch' => 'nullable|string|max:50',
            'asal_kampus' => 'nullable|string|max:100', // Tambahkan validasi ini
            'mentor_id' => 'nullable|exists:mentors,mentor_id',
            'joining_date' => 'required|date',
            'termination_date' => 'nullable|date|after_or_equal:joining_date',
        ]);

        $intern->user->username = $request->username;
        if ($request->filled('password')) {
            $intern->user->password = Hash::make($request->password);
        }
        $intern->user->save();

        $profilePictureName = $intern->profile_picture;
        if ($request->hasFile('profile_picture')) {
            if ($profilePictureName && Storage::disk('public')->exists('avatars/' . $profilePictureName)) {
                Storage::disk('public')->delete('avatars/' . $profilePictureName);
            }
            $image = $request->file('profile_picture');
            $profilePictureName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/avatars', $profilePictureName);
        } elseif ($request->input('remove_profile_picture')) {
            if ($profilePictureName && Storage::disk('public')->exists('avatars/' . $profilePictureName)) {
                Storage::disk('public')->delete('avatars/' . $profilePictureName);
            }
            $profilePictureName = null;
        }

        $intern->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'profile_picture' => $profilePictureName,
            'phone_number' => $request->phone_number,
            'batch' => $request->batch,
            'asal_kampus' => $request->asal_kampus, // Perbarui data ini
            'mentor_id' => $request->mentor_id,
            'joining_date' => $request->joining_date,
            'termination_date' => $request->termination_date,
        ]);

        return redirect()->route('admin.interns.index')->with('success', 'Profil peserta magang berhasil diperbarui!');
    }

    /**
     * Hapus peserta magang dari database (Admin).
     * Juga akan menghapus user terkait karena onDelete('cascade') di migration.
     *
     * @param  int  $internId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($internId)
    {
        $intern = Intern::findOrFail($internId);

        if ($intern->profile_picture && Storage::disk('public')->exists('avatars/' . $intern->profile_picture)) {
            Storage::disk('public')->delete('avatars/' . $intern->profile_picture);
        }

        $intern->delete();

        return redirect()->route('admin.interns.index')->with('success', 'Profil peserta magang berhasil dihapus!');
    }

    /**
     * Tampilkan profil peserta magang untuk peserta magang itu sendiri.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showInternProfile()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect()->route('intern.dashboard')->with('error', 'Profil Anda belum lengkap. Harap hubungi Admin.');
        }

        return view('intern.profile.show', compact('user', 'intern'));
    }

    /**
     * Tampilkan form untuk mengedit profil peserta magang (oleh dirinya sendiri).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editInternProfile()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect()->route('intern.dashboard')->with('error', 'Profil Anda belum lengkap. Harap hubungi Admin.');
        }

        return view('intern.profile.edit', compact('user', 'intern'));
    }

    /**
     * Perbarui profil peserta magang (oleh dirinya sendiri).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInternProfile(Request $request)
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect()->route('intern.dashboard')->with('error', 'Profil Anda belum lengkap. Harap hubungi Admin.');
        }

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('interns', 'email')->ignore($intern->intern_id, 'intern_id'),
            ],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'asal_kampus' => 'nullable|string|max:100', // Tambahkan validasi ini
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $profilePictureName = $intern->profile_picture;
        if ($request->hasFile('profile_picture')) {
            if ($profilePictureName && Storage::disk('public')->exists('avatars/' . $profilePictureName)) {
                Storage::disk('public')->delete('avatars/' . $profilePictureName);
            }
            $image = $request->file('profile_picture');
            $profilePictureName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/avatars', $profilePictureName);
        } elseif ($request->input('remove_profile_picture')) {
            if ($profilePictureName && Storage::disk('public')->exists('avatars/' . $profilePictureName)) {
                Storage::disk('public')->delete('avatars/' . $profilePictureName);
            }
            $profilePictureName = null;
        }

        $intern->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'profile_picture' => $profilePictureName,
            'phone_number' => $request->phone_number,
            'asal_kampus' => $request->asal_kampus, // Perbarui data ini
        ]);

        return redirect()->route('intern.profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
    }


    /**
     * Tampilkan profil peserta magang untuk Mentor (hanya interns yang dibimbing).
     *
     * @param  int  $internId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mentorShowInternProfile($internId)
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect()->route('mentor.dashboard')->with('error', 'Profil mentor Anda belum lengkap.');
        }

        $intern = Intern::with('user', 'mentor')->findOrFail($internId);

        if ($intern->mentor_id !== $mentor->mentor_id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat profil peserta magang ini.');
        }

        return view('mentor.interns.show', compact('intern', 'mentor'));
    }
}