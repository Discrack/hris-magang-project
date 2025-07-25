<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Anda bisa menambahkan logika untuk mengambil data khusus admin di sini
        $user = Auth::user(); // Mendapatkan user yang sedang login

        return view('admin.dashboard', compact('user')); // Kita akan membuat view ini nanti
    }
}