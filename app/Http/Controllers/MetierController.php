<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ouvriers.metiers.index', [
            'metiers' => \App\Models\Metier::with('domain')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.metiers.create', [
            'domaines' => \App\Models\Domain::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domain,id',
        ]);

        \App\Models\Metier::create($request->only('name', 'domain_id'));

        return redirect()->route('metiers.index')->with('success', 'Metier created successfully.');
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
        $metier = \App\Models\Metier::findOrFail($id)->load('domain');
        return view('ouvriers.metiers.edit', ['metier' => $metier, 'domaines' => \App\Models\Domain::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domain,id',
        ]);

        $metier = \App\Models\Metier::findOrFail($id);
        $metier->update($request->only('name', 'domain_id'));

        return redirect()->route('metiers.index')->with('success', 'Metier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metier = \App\Models\Metier::findOrFail($id);
        $metier->delete();

        return redirect()->route('metiers.index')->with('success', 'Metier deleted successfully.');
    }
}
