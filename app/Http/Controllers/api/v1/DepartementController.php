<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;

class DepartementController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'departements' => \App\Models\Departement::with('region', 'region.country')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('ouvriers.departements.create', [
        //     'regions' => \App\Models\Region::with('country')->get()
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:region,id',
        ]);

        \App\Models\Departement::create($request->only('name', 'region_id'));

        return ['message', 'Departement created successfully.'];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $departement = \App\Models\Departement::findOrFail($id)->load('region', 'region.country');
        return ['departement' => $departement, 'regions' => \App\Models\Region::with('country')->get()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:region,id',
        ]);

        $departement = \App\Models\Departement::findOrFail($id);
        $departement->update($request->only('name', 'region_id'));

        return['message', 'Departement updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departement = \App\Models\Departement::findOrFail($id);
        $departement->delete();

        return ['message', 'Departement deleted successfully.'];
    }
}
