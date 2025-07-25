<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar; // Import Model Calendar

class CalendarController extends Controller
{
    /**
     * Tampilkan daftar semua acara kalender (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        $events = Calendar::orderBy('start_date', 'desc')->get();
        return view('admin.calendar.index', compact('events'));
    }

    /**
     * Tampilkan form untuk membuat acara kalender baru (Admin).
     *
     * @return \Illuminate\View\View
     */
    public function adminCreate()
    {
        return view('admin.calendar.create');
    }

    /**
     * Simpan acara kalender baru ke database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Calendar::create($request->all());

        return redirect()->route('admin.calendar.index')->with('success', 'Acara kalender berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit acara kalender (Admin).
     *
     * @param  int  $eventId
     * @return \Illuminate\View\View
     */
    public function adminEdit($eventId)
    {
        $event = Calendar::findOrFail($eventId);
        return view('admin.calendar.edit', compact('event'));
    }

    /**
     * Perbarui acara kalender di database (Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request, $eventId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $event = Calendar::findOrFail($eventId);
        $event->update($request->all());

        return redirect()->route('admin.calendar.index')->with('success', 'Acara kalender berhasil diperbarui!');
    }

    /**
     * Hapus acara kalender dari database (Admin).
     *
     * @param  int  $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminDestroy($eventId)
    {
        $event = Calendar::findOrFail($eventId);
        $event->delete();

        return redirect()->route('admin.calendar.index')->with('success', 'Acara kalender berhasil dihapus!');
    }

    /**
     * Tampilkan daftar semua acara kalender (Umum, untuk Intern/Mentor/Admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $events = Calendar::orderBy('start_date', 'desc')->get();
        return view('general.calendar.index', compact('events'));
    }
}