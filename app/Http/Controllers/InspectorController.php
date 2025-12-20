<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // atau model Inspector jika ada

class InspectorController extends Controller
{
    public function create()
    {
        // Ambil semua inspector, sesuaikan dengan struktur database Anda
        $inspectors = User::where('role', 'inspector')->get(); // sesuaikan query
        
        return view('inspectors.create', compact('inspectors'));
    }

    public function destroy($id)
{
    $inspector = User::findOrFail($id);
    $inspector->delete();
    
    return redirect()->route('inspectors.create')->with('success', 'Inspector berhasil dihapus!');
}

public function update(Request $request, $id)
{
    $inspector = User::findOrFail($id);
    
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
    ];
    
    // Password optional saat update
    if ($request->filled('password')) {
        $rules['password'] = 'min:6';
    }
    
    $request->validate($rules);
    
    $inspector->name = $request->name;
    $inspector->email = $request->email;
    
    if ($request->filled('password')) {
        $inspector->password = bcrypt($request->password);
    }
    
    $inspector->save();
    
    return redirect()->route('inspectors.create')->with('success', 'Inspector berhasil diupdate!');
}
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'inspector',
        ]);
        
        return redirect()->route('inspectors.create')->with('success', 'Inspector berhasil ditambahkan!');
    }
}