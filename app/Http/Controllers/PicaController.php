<?php

namespace App\Http\Controllers;

use App\Models\Pica;
use Illuminate\Http\Request;

class PicaController extends Controller
{
    public function index()
    {
        $picas = Pica::latest('tanggal')->paginate(10);
        return view('picas.index', compact('picas'));
    }

    public function create()
    {
        return view('picas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'screen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'akar_penyebab' => 'required|string',
            'tindakan_perbaikan' => 'required|string',
            'screen_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'waktu_penyelesaian' => 'required|date',
            'pencegahan' => 'required|string',
            'pic' => 'required|string|max:255',
            'status' => 'required|in:Open,Close',
        ]);

        // Handle file upload untuk screen
        if ($request->hasFile('screen')) {
            $validated['screen'] = $request->file('screen')->store('pica-screens', 'public');
        }

        // Handle file upload untuk screen_2
        if ($request->hasFile('screen_2')) {
            $validated['screen_2'] = $request->file('screen_2')->store('pica-screens', 'public');
        }

        Pica::create($validated);

        return redirect()->route('picas.index')
            ->with('success', 'PICA berhasil ditambahkan!');
    }

    public function show(Pica $pica)
    {
        return view('picas.show', compact('pica'));
    }

    public function edit(Pica $pica)
    {
        return view('picas.edit', compact('pica'));
    }

    public function update(Request $request, Pica $pica)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'screen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'akar_penyebab' => 'required|string',
            'tindakan_perbaikan' => 'required|string',
            'screen_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'waktu_penyelesaian' => 'required|date',
            'pencegahan' => 'required|string',
            'pic' => 'required|string|max:255',
            'status' => 'required|in:Open,Close',
        ]);

        // Handle file upload untuk screen
        if ($request->hasFile('screen')) {
            if ($pica->screen) {
                \Storage::disk('public')->delete($pica->screen);
            }
            $validated['screen'] = $request->file('screen')->store('pica-screens', 'public');
        }

        // Handle file upload untuk screen_2
        if ($request->hasFile('screen_2')) {
            if ($pica->screen_2) {
                \Storage::disk('public')->delete($pica->screen_2);
            }
            $validated['screen_2'] = $request->file('screen_2')->store('pica-screens', 'public');
        }

        $pica->update($validated);

        return redirect()->route('picas.index')
            ->with('success', 'PICA berhasil diupdate!');
    }

    public function destroy(Pica $pica)
    {
        if ($pica->screen) {
            \Storage::disk('public')->delete($pica->screen);
        }
        if ($pica->screen_2) {
            \Storage::disk('public')->delete($pica->screen_2);
        }

        $pica->delete();

        return redirect()->route('picas.index')
            ->with('success', 'PICA berhasil dihapus!');
    }
}