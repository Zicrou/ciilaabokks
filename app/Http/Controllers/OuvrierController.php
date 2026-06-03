<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OuvrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ouvriers.ouvriers.index', [
            'ouvriers' => \App\Models\Ouvrier::with(['metier.domain', 'region', 'departement', 'country'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.ouvriers.create', [
            'countries' => \App\Models\Country::all(),
            'regions' => \App\Models\Region::with('country')->get(),
            'departements' => \App\Models\Departement::with('region')->get(),
            'metiers' => \App\Models\Metier::with('domain')->get(),
            'domains' => \App\Models\Domain::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:country,id',
            'region_id' => 'required|exists:region,id',
            'departement_id' => 'required|exists:departement,id',
            'metier_id' => 'required|exists:metier,id',
            'domain_id' => 'required|exists:domain,id',
            'date_of_birth' => 'required|date',
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'phone_number' => ['required', 'string', 'max:255', 'unique:ouvrier,phone_number'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number_2' => ['nullable', 'string', 'max:255'],
            'photo_cni' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'numero_cni' => ['nullable', 'string', 'max:255']
        ]);

        \App\Models\Ouvrier::create($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni'));

        return redirect()->route('ouvriers.index')->with('success', 'Ouvrier created successfully.');
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
        $ouvrier = \App\Models\Ouvrier::findOrFail($id)->load(['metier.domain', 'region', 'departement', 'country']);
        return view('ouvriers.ouvriers.edit', [
            'ouvrier' => $ouvrier,
            'countries' => \App\Models\Country::all(),
            'regions' => \App\Models\Region::with('country')->get(),
            'departements' => \App\Models\Departement::with('region')->get(),
            'metiers' => \App\Models\Metier::with('domain')->get(),
            'domains' => \App\Models\Domain::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:country,id',
            'region_id' => 'required|exists:region,id',
            'departement_id' => 'required|exists:departement,id',
            'metier_id' => 'required|exists:metier,id',
            'domain_id' => 'required|exists:domain,id',
            'date_of_birth' => 'required|date',
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'phone_number' => ['required', 'string', 'max:255', 'unique:ouvrier,phone_number,' . $id],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number_2' => ['nullable', 'string', 'max:255'],
            'photo_cni' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            'numero_cni' => ['nullable', 'string', 'max:255']
        ]);

        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        $ouvrier->update($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni'));

        return redirect()->route('ouvriers.index')->with('success', 'Ouvrier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        $ouvrier->delete();

        return redirect()->route('ouvriers.index')->with('success', 'Ouvrier deleted successfully.');
    }
}
