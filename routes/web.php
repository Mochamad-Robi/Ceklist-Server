<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerChecklistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PicaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    // Dashboard - Semua user bisa akses
    Route::get('/dashboard', function () {
        $stats = [
            'total' => \App\Models\ServerChecklist::count(),
            'completed' => \App\Models\ServerChecklist::where('status', 'completed')->count(),
            'draft' => \App\Models\ServerChecklist::where('status', 'draft')->count(),
            'this_month' => \App\Models\ServerChecklist::whereMonth('inspection_date', date('m'))->count(),
        ];
        
        $stats['completed_percentage'] = $stats['total'] > 0 
            ? round(($stats['completed'] / $stats['total']) * 100) 
            : 0;
        
        $monthly_trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('M Y', strtotime("-$i months"));
            $count = \App\Models\ServerChecklist::whereYear('inspection_date', date('Y', strtotime("-$i months")))
                ->whereMonth('inspection_date', date('m', strtotime("-$i months")))
                ->count();
            $monthly_trend[$month] = $count;
        }
        
        $results_stats = [
            'ok' => \App\Models\ServerChecklist::sum('ok_items'),
            'not_ok' => \App\Models\ServerChecklist::sum('not_ok_items'),
            'attention' => \App\Models\ServerChecklist::sum('attention_items'),
        ];
        
        $recent_checklists = \App\Models\ServerChecklist::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('checklists.dashboard', compact('stats', 'monthly_trend', 'results_stats', 'recent_checklists'));
    })->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Checklist Routes - Semua user bisa akses
    // IMPORTANT: Routes dengan path spesifik harus di atas routes dengan parameter dinamis
    Route::get('/checklists/report', [ServerChecklistController::class, 'report'])->name('checklists.report');
    
    Route::get('/checklists', [ServerChecklistController::class, 'index'])->name('checklists.index');
    Route::get('/checklists/create', [ServerChecklistController::class, 'create'])->name('checklists.create');
    Route::post('/checklists', [ServerChecklistController::class, 'store'])->name('checklists.store');
    Route::get('/checklists/{checklist}', [ServerChecklistController::class, 'show'])->name('checklists.show');
    Route::get('/checklists/{checklist}/edit', [ServerChecklistController::class, 'edit'])->name('checklists.edit');
    Route::put('/checklists/{checklist}', [ServerChecklistController::class, 'update'])->name('checklists.update');
    Route::get('/checklists/{checklist}/export-csv', [ServerChecklistController::class, 'exportCsv'])->name('checklists.export-csv');
    Route::get('/api/checklist-template', [ServerChecklistController::class, 'getDefaultTemplate']);
    Route::get('/inspectors/create', [InspectorController::class, 'create'])->name('inspectors.create');
    Route::post('/inspectors', [InspectorController::class, 'store'])->name('inspectors.store');
    Route::delete('/inspectors/{id}', [InspectorController::class, 'destroy'])->name('inspectors.destroy');
    Route::put('/inspectors/{id}', [InspectorController::class, 'update'])->name('inspectors.update');
    
    Route::get('/inspectors/create', [InspectorController::class, 'create'])->name('inspectors.create');
    Route::post('/inspectors', [InspectorController::class, 'store'])->name('inspectors.store');
    Route::delete('/inspectors/{id}', [InspectorController::class, 'destroy'])->name('inspectors.destroy');
    Route::put('/inspectors/{id}', [InspectorController::class, 'update'])->name('inspectors.update');

    // Route PICA - Ganti dengan ini
    Route::resource('picas', PicaController::class);
    
    // Delete - HANYA ADMIN
    Route::delete('/checklists/{checklist}', [ServerChecklistController::class, 'destroy'])
        ->name('checklists.destroy')
        ->middleware('role:admin');

    Route::middleware('auth')->group(function () {
    // ... routes lain ...
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update'); // INI PENTING!
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    });
    
    // User Management - HANYA ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';