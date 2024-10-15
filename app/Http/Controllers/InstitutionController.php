<?php
namespace App\Http\Controllers;

use App\Models\Institution;
use Inertia\Inertia;

use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
    
        if ($user->hasRole('superadmin')) {
            $institutions = Institution::all();
        } else {
            $institutions = Institution::where('institution', $user->institution)->get();
        }
    
        return Inertia::render('Institutions/Index', [
            'institutions' => $institutions,
        ]);
    }
    

    public function show($id)
    {
        $institution = Institution::findOrFail($id);
        return response()->json($institution);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other fields as necessary
        ]);

        $tenant = request()->attributes->get('tenant');
        $institution = Institution::create(array_merge($request->all(), ['institution' => $tenant]));

        return response()->json($institution, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
        ]);

        $institution = Institution::findOrFail($id);
        $institution->update($request->all());

        return response()->json($institution);
    }

    public function destroy($id)
    {
        $institution = Institution::findOrFail($id);
        $institution->delete();

        return response()->json(null, 204);
    }
}
