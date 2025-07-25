<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment; // Import Model Assessment
use App\Models\Intern;     // Import Model Intern
use App\Models\Mentor;     // Import Model Mentor
use Carbon\Carbon;         // Import Carbon untuk manipulasi tanggal

class AssessmentController extends Controller
{
    /**
     * Tampilkan form untuk memberikan penilaian dan feedback (Mentor).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mentorCreate()
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect()->route('mentor.dashboard')->with('error', 'Profil mentor Anda belum lengkap. Silakan hubungi admin.');
        }

        // Ambil interns yang dibimbing oleh mentor ini
        $interns = Intern::where('mentor_id', $mentor->mentor_id)->orderBy('full_name')->get();

        return view('mentor.assessments.create', compact('interns', 'mentor'));
    }

    /**
     * Simpan penilaian dan feedback baru ke database (Mentor).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mentorStore(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return back()->with('error', 'Profil mentor Anda belum lengkap.');
        }

        $request->validate([
            'intern_id' => [
                'required',
                'exists:interns,intern_id',
                // Pastikan intern ini dibimbing oleh mentor yang sedang login
                function ($attribute, $value, $fail) use ($mentor) {
                    if (!Intern::where('intern_id', $value)->where('mentor_id', $mentor->mentor_id)->exists()) {
                        $fail('Peserta magang yang dipilih tidak berada di bawah bimbingan Anda.');
                    }
                },
            ],
            'rating' => 'required|integer|min:1|max:5', // Skala 1-5
            'feedback' => 'nullable|string',
        ]);

        Assessment::create([
            'intern_id' => $request->intern_id,
            'mentor_id' => $mentor->mentor_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'assessment_date' => Carbon::now()->toDateString(), // Tanggal penilaian hari ini
        ]);

        return redirect()->route('mentor.dashboard')->with('success', 'Penilaian dan feedback berhasil diberikan!');
    }

    /**
     * Tampilkan daftar semua penilaian dan feedback (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        $assessments = Assessment::with('intern.user', 'mentor.user')->orderBy('assessment_date', 'desc')->get();
        return view('admin.assessments.index', compact('assessments'));
    }

    /**
     * Tampilkan form untuk mengedit penilaian dan feedback (Admin).
     *
     * @param  int  $assessmentId
     * @return \Illuminate\View\View
     */
    public function adminEdit($assessmentId)
    {
        $assessment = Assessment::with('intern.user', 'mentor.user')->findOrFail($assessmentId);
        $interns = Intern::all(); // Untuk dropdown jika perlu ganti intern
        $mentors = Mentor::all(); // Untuk dropdown jika perlu ganti mentor
        return view('admin.assessments.edit', compact('assessment', 'interns', 'mentors'));
    }

    /**
     * Perbarui penilaian dan feedback di database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $assessmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request, $assessmentId)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,intern_id',
            'mentor_id' => 'required|exists:mentors,mentor_id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'assessment_date' => 'required|date',
        ]);

        $assessment = Assessment::findOrFail($assessmentId);
        $assessment->update($request->all());

        return redirect()->route('admin.assessments.index')->with('success', 'Penilaian dan feedback berhasil diperbarui!');
    }

    /**
     * Hapus penilaian dan feedback dari database (Admin).
     *
     * @param  int  $assessmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminDestroy($assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $assessment->delete();

        return redirect()->route('admin.assessments.index')->with('success', 'Penilaian dan feedback berhasil dihapus!');
    }

    /**
     * Tampilkan daftar penilaian dan feedback untuk peserta magang (Intern).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function internIndex()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect()->route('intern.dashboard')->with('error', 'Profil peserta magang Anda belum lengkap. Silakan hubungi admin.');
        }

        $assessments = Assessment::where('intern_id', $intern->intern_id)
            ->with('mentor.user') // Load mentor's user data for name
            ->orderBy('assessment_date', 'desc')
            ->get();

        return view('intern.assessments.index', compact('assessments', 'intern'));
    }
}