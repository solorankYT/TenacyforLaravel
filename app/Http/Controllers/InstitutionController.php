<?php
namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        // Fetch institutions based on the authenticated user's institution
        $tenant = request()->attributes->get('tenant');
        return Institution::where('institution', $tenant)->get();
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
            // Add other fields as necessary
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
