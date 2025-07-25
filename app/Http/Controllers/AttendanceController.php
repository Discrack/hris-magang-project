<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Intern;
use App\Models\User;
use App\Models\Mentor; // Pastikan ini diimpor
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Tampilkan halaman presensi untuk peserta magang (intern).
     * Termasuk status check-in/out hari ini dan riwayat.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect('/intern/dashboard')->with('error', 'Profil peserta magang Anda belum lengkap. Silakan hubungi admin.');
        }

        $today = Carbon::today();

        // Cari catatan kehadiran hari ini untuk intern yang sedang login
        $todayAttendance = Attendance::where('intern_id', $intern->intern_id)
            ->whereDate('attendance_date', $today)
            ->first();

        // Dapatkan riwayat presensi untuk intern ini (misal, 10 catatan terakhir)
        $attendanceHistory = Attendance::where('intern_id', $intern->intern_id)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('check_in_time', 'desc')
            ->limit(10)
            ->get();

        return view('intern.attendance', compact('user', 'intern', 'todayAttendance', 'attendanceHistory'));
    }

    /**
     * Tangani proses check-in peserta magang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return back()->with('error', 'Profil peserta magang Anda belum lengkap.');
        }

        $today = Carbon::today();

        // Cek apakah sudah check-in hari ini
        $existingAttendance = Attendance::where('intern_id', $intern->intern_id)
            ->whereDate('attendance_date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->check_in_time) {
            return back()->with('error', 'Anda sudah check-in hari ini.');
        }

        // Buat catatan kehadiran baru
        Attendance::create([
            'intern_id' => $intern->intern_id,
            'attendance_date' => $today,
            'check_in_time' => Carbon::now(),
            'notes' => 'Check-in otomatis',
        ]);

        return back()->with('success', 'Check-in berhasil!');
    }

    /**
     * Tangani proses check-out peserta magang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return back()->with('error', 'Profil peserta magang Anda belum lengkap.');
        }

        $today = Carbon::today();

        // Cari catatan kehadiran hari ini yang sudah check-in tapi belum check-out
        $todayAttendance = Attendance::where('intern_id', $intern->intern_id)
            ->whereDate('attendance_date', $today)
            ->whereNotNull('check_in_time')
            ->whereNull('check_out_time')
            ->first();

        if (!$todayAttendance) {
            return back()->with('error', 'Anda belum check-in hari ini atau sudah check-out.');
        }

        // Update waktu check-out
        $todayAttendance->update([
            'check_out_time' => Carbon::now(),
            'notes' => 'Check-out otomatis',
        ]);

        return back()->with('success', 'Check-out berhasil!');
    }

    /**
     * Tampilkan halaman manajemen presensi untuk Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        // Mendapatkan tanggal yang dipilih, default hari ini
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $carbonDate = Carbon::parse($selectedDate);

        // Ambil semua peserta magang
        $interns = Intern::with([
            'attendances' => function ($query) use ($carbonDate) {
                $query->whereDate('attendance_date', $carbonDate);
            }
        ])->get();

        return view('admin.attendance', compact('interns', 'selectedDate', 'carbonDate'));
    }

    /**
     * Tampilkan detail presensi untuk intern tertentu (untuk Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $internId
     * @return \Illuminate\View\View
     */
    public function adminShow(Request $request, $internId)
    {
        $intern = Intern::with('user', 'mentor')->findOrFail($internId);

        // Ambil riwayat presensi lengkap untuk intern ini
        $attendanceHistory = Attendance::where('intern_id', $internId)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('check_in_time', 'desc')
            ->get();

        return view('admin.intern_attendance_detail', compact('intern', 'attendanceHistory'));
    }

    /**
     * Tampilkan halaman presensi untuk Mentor (hanya interns yang dibimbing).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function mentorIndex(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentor; // Dapatkan model Mentor yang terkait

        if (!$mentor) {
            return redirect('/mentor/dashboard')->with('error', 'Profil mentor Anda belum lengkap. Silakan hubungi admin.');
        }

        // Mendapatkan tanggal yang dipilih, default hari ini
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $carbonDate = Carbon::parse($selectedDate);

        // Ambil interns yang dibimbing oleh mentor ini
        $interns = Intern::where('mentor_id', $mentor->mentor_id)
            ->with([
                'attendances' => function ($query) use ($carbonDate) {
                    $query->whereDate('attendance_date', $carbonDate);
                }
            ])->get();

        return view('mentor.attendance', compact('interns', 'selectedDate', 'carbonDate', 'mentor'));
    }

    /**
     * Tampilkan detail presensi untuk intern tertentu (untuk Mentor).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $internId
     * @return \Illuminate\View\View
     */
    public function mentorShow(Request $request, $internId)
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect('/mentor/dashboard')->with('error', 'Profil mentor Anda belum lengkap.');
        }

        $intern = Intern::with('user', 'mentor')->findOrFail($internId);

        // Pastikan intern ini dibimbing oleh mentor yang sedang login
        if ($intern->mentor_id !== $mentor->mentor_id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat detail presensi peserta magang ini.');
        }

        // Ambil riwayat presensi lengkap untuk intern ini
        $attendanceHistory = Attendance::where('intern_id', $internId)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('check_in_time', 'desc')
            ->get();

        return view('mentor.intern_attendance_detail', compact('intern', 'attendanceHistory', 'mentor'));
    }
}