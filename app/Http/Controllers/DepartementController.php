<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ouvriers.departements.index', [
            'departements' => \App\Models\Departement::with('region', 'region.country')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.departements.create', [
            'regions' => \App\Models\Region::with('country')->get()
        ]);
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

        return redirect()->route('departements.index')->with('success', 'Departement created successfully.');
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
        return view('ouvriers.departements.edit', ['departement' => $departement, 'regions' => \App\Models\Region::with('country')->get()]);
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

        return redirect()->route('departements.index')->with('success', 'Departement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departement = \App\Models\Departement::findOrFail($id);
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Departement deleted successfully.');
    }
}
