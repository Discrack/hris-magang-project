<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mentor;
use App\Models\Intern; // Import Model Intern

class MentorDashboardController extends Controller
{
    /**
     * Tampilkan dashboard mentor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        // Ambil daftar peserta magang yang dibimbing oleh mentor ini
        $bimbinganInterns = collect(); // Default empty collection
        if ($mentor) {
            $bimbinganInterns = Intern::where('mentor_id', $mentor->mentor_id)
                ->with('user') // Load user data for username if needed
                ->orderBy('full_name')
                ->get();
        }


        return view('mentor.dashboard', compact('user', 'mentor', 'bimbinganInterns'));
    }
}