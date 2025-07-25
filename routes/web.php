<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\InternDashboardController; // Pastikan ini diimpor
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\InternProfileController;
use App\Http\Controllers\ProgramInfoController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AssessmentController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk halaman awal, bisa diarahkan ke login jika belum login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user instanceof User) {
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'intern') {
                return redirect('/intern/dashboard');
            } elseif ($user->role === 'mentor') {
                return redirect('/mentor/dashboard');
            }
        }
    }
    return redirect('/login');
});

// Rute Otentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute yang memerlukan otentikasi
Route::middleware(['auth'])->group(function () {
    // Rute untuk dashboard default setelah login (jika peran tidak terdefinisi)
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Rute Dashboard & Fitur Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Presensi Admin
        Route::get('/admin/attendance', [AttendanceController::class, 'adminIndex'])->name('admin.attendance');
        Route::get('/admin/attendance/{internId}', [AttendanceController::class, 'adminShow'])->name('admin.attendance.show');

        // Pengelolaan Gaji Admin
        Route::prefix('admin/payroll')->name('admin.payroll.')->group(function () {
            Route::get('/', [PayrollController::class, 'adminIndex'])->name('index');
            Route::get('/create', [PayrollController::class, 'adminCreate'])->name('create');
            Route::post('/', [PayrollController::class, 'adminStore'])->name('store');
            Route::get('/{payrollId}/edit', [PayrollController::class, 'adminEdit'])->name('edit');
            Route::put('/{payrollId}', [PayrollController::class, 'adminUpdate'])->name('update');
            Route::delete('/{payrollId}', [PayrollController::class, 'adminDestroy'])->name('destroy');
        });

        // Manajemen Profil Peserta Magang Admin
        Route::prefix('admin/interns')->name('admin.interns.')->group(function () {
            Route::get('/', [InternProfileController::class, 'index'])->name('index'); // Ini adalah rute admin.interns.index
            Route::get('/create', [InternProfileController::class, 'create'])->name('create');
            Route::post('/', [InternProfileController::class, 'store'])->name('store');
            Route::get('/{internId}/edit', [InternProfileController::class, 'edit'])->name('edit');
            Route::put('/{internId}', [InternProfileController::class, 'update'])->name('update');
            Route::delete('/{internId}', [InternProfileController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Informasi Program Admin
        Route::prefix('admin/program-info')->name('admin.program_info.')->group(function () {
            Route::get('/', [ProgramInfoController::class, 'adminIndex'])->name('index');
            Route::get('/create', [ProgramInfoController::class, 'adminCreate'])->name('create');
            Route::post('/', [ProgramInfoController::class, 'adminStore'])->name('store');
            Route::get('/{infoId}/edit', [ProgramInfoController::class, 'adminEdit'])->name('edit');
            Route::put('/{infoId}', [ProgramInfoController::class, 'adminUpdate'])->name('update');
            Route::delete('/{infoId}', [ProgramInfoController::class, 'adminDestroy'])->name('destroy');
        });

        // Manajemen Kalender Program Admin
        Route::prefix('admin/calendar')->name('admin.calendar.')->group(function () {
            Route::get('/', [CalendarController::class, 'adminIndex'])->name('index');
            Route::get('/create', [CalendarController::class, 'adminCreate'])->name('create');
            Route::post('/', [CalendarController::class, 'adminStore'])->name('store');
            Route::get('/{eventId}/edit', [CalendarController::class, 'adminEdit'])->name('edit');
            Route::put('/{eventId}', [CalendarController::class, 'adminUpdate'])->name('update');
            Route::delete('/{eventId}', [CalendarController::class, 'adminDestroy'])->name('destroy');
        });

        // Manajemen Penilaian & Feedback Admin
        Route::prefix('admin/assessments')->name('admin.assessments.')->group(function () {
            Route::get('/', [AssessmentController::class, 'adminIndex'])->name('index');
            Route::get('/{assessmentId}/edit', [AssessmentController::class, 'adminEdit'])->name('edit');
            Route::put('/{assessmentId}', [AssessmentController::class, 'adminUpdate'])->name('update');
            Route::delete('/{assessmentId}', [AssessmentController::class, 'adminDestroy'])->name('destroy');
        });
    });

    // Rute Dashboard & Fitur Intern
    Route::middleware(['role:intern'])->group(function () {
        // Ini adalah rute untuk dashboard intern
        Route::get('/intern/dashboard', [InternDashboardController::class, 'index'])->name('intern.dashboard');

        // Presensi Intern
        Route::get('/intern/attendance', [AttendanceController::class, 'index'])->name('intern.attendance');
        Route::post('/intern/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('intern.checkin');
        Route::post('/intern/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('intern.checkout');

        // Penggajian Intern
        Route::get('/intern/payroll', [PayrollController::class, 'internIndex'])->name('intern.payroll');

        // Profil Peserta Magang (oleh dirinya sendiri)
        Route::prefix('intern/profile')->name('intern.profile.')->group(function () {
            Route::get('/', [InternProfileController::class, 'showInternProfile'])->name('show');
            Route::get('/edit', [InternProfileController::class, 'editInternProfile'])->name('edit');
            Route::put('/', [InternProfileController::class, 'updateInternProfile'])->name('update');
        });

        // Penilaian & Feedback Intern
        Route::get('/intern/assessments', [AssessmentController::class, 'internIndex'])->name('intern.assessments.index');
    });

    // Rute Dashboard & Fitur Mentor
    Route::middleware(['role:mentor'])->group(function () {
        Route::get('/mentor/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');

        // Presensi Mentor
        Route::get('/mentor/attendance', [AttendanceController::class, 'mentorIndex'])->name('mentor.attendance');
        Route::get('/mentor/attendance/{internId}', [AttendanceController::class, 'mentorShow'])->name('mentor.attendance.show');

        // Profil Peserta Magang (untuk dilihat oleh Mentor)
        Route::get('/mentor/interns/{internId}/profile', [InternProfileController::class, 'mentorShowInternProfile'])->name('mentor.interns.profile.show');

        // Penilaian & Feedback Mentor
        Route::prefix('mentor/assessments')->name('mentor.assessments.')->group(function () {
            Route::get('/create', [AssessmentController::class, 'mentorCreate'])->name('create');
            Route::post('/', [AssessmentController::class, 'mentorStore'])->name('store');
        });
    });

    // Rute Umum (dapat diakses oleh semua peran yang sudah login)
    Route::get('/program-info', [ProgramInfoController::class, 'index'])->name('general.program_info.index');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('general.calendar.index');
});