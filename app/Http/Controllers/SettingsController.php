<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServerChecklist;

class SettingsController extends Controller
{
    public function index()
    {
        // Hanya super admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access');
        }
        
        return view('settings.index');
    }
}