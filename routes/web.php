<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\InstitutionController;
use App\Http\Middleware\SetInstitution;
use App\Http\Controllers\PermissionsController as PermissionsController;
use App\Http\Controllers\RolesController as RolesController;

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
        // Get the institution set by the middleware
        $institution = $request->attributes->get('institution');
    
        // If institution is 'all', user is Super 
        if ($institution === 'all') {
            return Inertia::render('Dashboard', [
                'institution' => 'Super : Access to all institutions',
                
            ]);
        }
    
        // For regular users, show their institution
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


    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');

    // Permissions
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionsController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionsController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionsController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionsController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionsController::class, 'destroy'])->name('permissions.destroy');

});


require __DIR__.'/auth.php';
