<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\InstitutionController;
use App\Http\Middleware\SetInstitution;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', SetInstitution::class])->group(function () {

    Route::get('/dashboard', function (Request $request) {
        // Retrieve the institution set by the middleware
        $institution = $request->attributes->get('institution');
    
        // Pass the institution data to the dashboard view
        return Inertia::render('Dashboard', [
            'institution' => $institution,
        ]);
    })->middleware(['auth', SetInstitution::class])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Institution routes
    Route::get('/institutions', [InstitutionController::class, 'index']);
    Route::get('/institutions/{id}', [InstitutionController::class, 'show']);
    Route::post('/institutions', [InstitutionController::class, 'store']);
    Route::put('/institutions/{id}', [InstitutionController::class, 'update']);
    Route::delete('/institutions/{id}', [InstitutionController::class, 'destroy']);

});


require __DIR__.'/auth.php';
