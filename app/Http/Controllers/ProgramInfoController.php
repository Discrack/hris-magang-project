<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramInfo; // Import Model ProgramInfo
use Illuminate\Support\Str;

class ProgramInfoController extends Controller
{
    /**
     * Tampilkan daftar semua informasi program (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        $programInfos = ProgramInfo::orderBy('created_at', 'desc')->get();
        return view('admin.program_info.index', compact('programInfos'));
    }

    /**
     * Tampilkan form untuk membuat informasi program baru (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminCreate()
    {
        return view('admin.program_info.create');
    }

    /**
     * Simpan informasi program baru ke database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        ProgramInfo::create($request->all());

        return redirect()->route('admin.program_info.index')->with('success', 'Informasi program berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit informasi program (Admin).
     *
     * @param  int  $infoId
     * @return \Illuminate\View\View
     */
    public function adminEdit($infoId)
    {
        $programInfo = ProgramInfo::findOrFail($infoId);
        return view('admin.program_info.edit', compact('programInfo'));
    }

    /**
     * Perbarui informasi program di database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $infoId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request, $infoId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $programInfo = ProgramInfo::findOrFail($infoId);
        $programInfo->update($request->all());

        return redirect()->route('admin.program_info.index')->with('success', 'Informasi program berhasil diperbarui!');
    }

    /**
     * Hapus informasi program dari database (Admin).
     *
     * @param  int  $infoId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminDestroy($infoId)
    {
        $programInfo = ProgramInfo::findOrFail($infoId);
        $programInfo->delete();

        return redirect()->route('admin.program_info.index')->with('success', 'Informasi program berhasil dihapus!');
    }

    /**
     * Tampilkan daftar semua informasi program (Umum, untuk Intern/Mentor/Admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $programInfos = ProgramInfo::orderBy('created_at', 'desc')->get();
        return view('general.program_info.index', compact('programInfos'));
    }
}