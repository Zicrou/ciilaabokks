<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DiplomeController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ouvriers.diplomes.index', [
            'diplomes' => \App\Models\Diplome::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.diplomes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\Diplome::create($request->only('name'));

        return redirect()->route('diplomes.index')->with('success', 'Diplome created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diplome = \App\Models\Diplome::findOrFail($id);
        return view('ouvriers.diplomes.edit', compact('diplome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $diplome = \App\Models\Diplome::findOrFail($id);
        $diplome->update($request->only('name'));

        return redirect()->route('diplomes.index')->with('success', 'Diplome updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diplome = \App\Models\Diplome::findOrFail($id);
        $diplome->delete();

        return redirect()->route('diplomes.index')->with('success', 'Diplome deleted successfully.');
    }
}
