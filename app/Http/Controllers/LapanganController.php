<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lapangans = Lapangan::all();
        return view('lapangan.index', compact('lapangans'));
    }

    
    public function create()
    {
        return view('lapangan.create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Sintetis,Vinyl,Rumput Asli',
            'harga_per_jam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Tersedia,Dalam Perbaikan,Tidak Aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        Lapangan::create($validated);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function show(Lapangan $lapangan)
    {
        return view('lapangan.show', compact('lapangan'));
    }

    public function edit(Lapangan $lapangan)
    {
        
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Sintetis,Vinyl,Rumput Asli',
            'harga_per_jam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Tersedia,Dalam Perbaikan,Tidak Aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($lapangan->foto) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update($validated);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil diupdate!');
    }

    public function destroy(Lapangan $lapangan)
    {
        
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }

        $lapangan->delete();

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}