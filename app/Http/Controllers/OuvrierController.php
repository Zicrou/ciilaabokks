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
        $departements = \App\Models\Departement::all();
        $metiers = \App\Models\Metier::all();
        $regions = \App\Models\Region::all();
        $domaines = \App\Models\Domain::all();
        return view('ouvriers.ouvriers.index', [
            'ouvriers' => \App\Models\Ouvrier::with(['metier.domain', 'region', 'departement', 'country'])->get(),
            'departements' => $departements,
            'metiers' => $metiers,
            'regions' => $regions,
            'domaines' => $domaines
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

    public function filtered()
    {
        if (request()->has('regionId')) {
            $departements = \App\Models\Region::find(request()->get('regionId'))->departements;
            return response()->json($departements);
        } elseif (request()->has('domaineId')) {
            $metiers = \App\Models\Domaine::find(request()->get('domaineId'))->metiers;
            return response()->json($metiers);
        } else {
            return response()->json([]);
        }
    }
    # @region = params[:regionId]
    # @domaine = params[:domaineId]
    # if !@region.nil?
    #   @departements = Departement.where(region_id:@region)
    #   puts "region= "+ @region
    #   respond_to do |format|
    #     format.json { render json: @departements }
    #   end

    # elsif !@domaine.nil?
    #   @metiers = Metier.where(domaine_id:@domaine)
    #   puts "domaine= "+ @domaine
    #   respond_to do |format|
    #     format.json { render json: @metiers }
    #   end
    # end
    #render :index
    

  public function rechercher(Request $request){
    $domaine = $request->get('domaine_id');
    $region = $request->get('region_id');
    $departement = $request->get('departement_id');
    $metier = $request->get('metier_id');
    $query = \App\Models\Ouvrier::query();
    if ($domaine) {
        $query->where('domain_id', $domaine);
    }

    if ($metier) {
        $query->where('metier_id', $metier);
    }
    if ($region) {
        $query->where('region_id', $region);
    }
    if ($departement) {
        $query->where('departement_id', $departement);
    }
    $ouvriers = $query->with(['metier.domain', 'region', 'departement', 'country'])
    ->get();
    $metiers = \App\Models\Metier::all();
    $departements = \App\Models\Departement::all();
    $regions = \App\Models\Region::all();
    $domaines = \App\Models\Domain::all();
    return view('ouvriers.ouvriers.index', ['ouvriers' => $ouvriers, 'departements' => $departements, 'metiers' => $metiers, 'domaines' => $domaines, 'regions' => $regions]);
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
            'numero_cni' => ['nullable', 'string', 'max:255'],
            'annees_experience' => ['numeric', 'max:255'],
            'entreprises' => ['nullable', 'string', 'max:255']
        ]);

        \App\Models\Ouvrier::create($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni','annees_experience', 'entreprises'));

        return redirect()->route('ouvriers.index')->with('success', 'Ouvrier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Ouvrier $ouvrier)
    {
        $ouvrier->load(['metier.domain', 'region', 'departement', 'country']);
        return view('ouvriers.ouvriers.show', compact('ouvrier'));
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
            'numero_cni' => ['nullable', 'string', 'max:255'],
            'annees_experience' => ['numeric', 'max:255'],
            'entreprises' => ['nullable', 'string', 'max:255']
        ]);

        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        $ouvrier->update($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni','annees_experience','entreprises'));

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
