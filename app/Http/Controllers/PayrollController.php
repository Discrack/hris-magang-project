<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll; // Import Model Payroll
use App\Models\Intern;  // Import Model Intern
use Carbon\Carbon;       // Import Carbon untuk manipulasi tanggal

class PayrollController extends Controller
{
    /**
     * Tampilkan halaman daftar penggajian untuk Admin.
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        // Ambil semua data penggajian, dengan eager loading data intern yang terkait
        $payrolls = Payroll::with('intern.user')->orderBy('payment_date', 'desc')->get();

        return view('admin.payroll.index', compact('payrolls'));
    }

    /**
     * Tampilkan form untuk membuat catatan penggajian baru (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminCreate()
    {
        $interns = Intern::all(); // Ambil semua intern untuk dropdown pilihan
        return view('admin.payroll.create', compact('interns'));
    }

    /**
     * Simpan catatan penggajian baru ke database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,intern_id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        Payroll::create($request->all());

        return redirect()->route('admin.payroll.index')->with('success', 'Catatan penggajian berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit catatan penggajian (Admin).
     *
     * @param  int  $payrollId
     * @return \Illuminate\View\View
     */
    public function adminEdit($payrollId)
    {
        $payroll = Payroll::with('intern')->findOrFail($payrollId);
        $interns = Intern::all(); // Ambil semua intern untuk dropdown pilihan
        return view('admin.payroll.edit', compact('payroll', 'interns'));
    }

    /**
     * Perbarui catatan penggajian di database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $payrollId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request, $payrollId)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,intern_id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $payroll = Payroll::findOrFail($payrollId);
        $payroll->update($request->all());

        return redirect()->route('admin.payroll.index')->with('success', 'Catatan penggajian berhasil diperbarui!');
    }

    /**
     * Hapus catatan penggajian dari database (Admin).
     *
     * @param  int  $payrollId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminDestroy($payrollId)
    {
        $payroll = Payroll::findOrFail($payrollId);
        $payroll->delete();

        return redirect()->route('admin.payroll.index')->with('success', 'Catatan penggajian berhasil dihapus!');
    }

    /**
     * Tampilkan riwayat penggajian untuk peserta magang (Intern).
     *
     * @return \Illuminate\View\View
     */
    public function internIndex()
    {
        $user = Auth::user();
        $intern = $user->intern;

        if (!$intern) {
            return redirect('/intern/dashboard')->with('error', 'Profil peserta magang Anda belum lengkap. Silakan hubungi admin.');
        }

        // Ambil riwayat penggajian untuk intern yang sedang login
        $payrolls = Payroll::where('intern_id', $intern->intern_id)
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('intern.payroll', compact('payrolls', 'user', 'intern'));
    }
}