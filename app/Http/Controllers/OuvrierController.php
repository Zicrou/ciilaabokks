<?php

namespace App\Http\Controllers;

use App\Http\Requests\OuvrierFormRequest;
use App\Http\Requests\OuvrierUpdateFormRequest;
use App\Models\Entreprise;
use App\Models\Ouvrier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $domaines = \App\Models\Domaine::all();
        $ouvriers = \App\Models\Ouvrier::query()
        ->with([
        'metiers.domaine',
        'region',
        'departement',
        'country',
        'entreprises'
    ])->get();
    
        return view('ouvriers.ouvriers.index', [
            'ouvriers' => $ouvriers,
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
            'countries' => \App\Models\Countries::all(),
            'regions' => \App\Models\Region::with('country')->get(),
            'departements' => \App\Models\Departement::all(),
            'metiers' => \App\Models\Metier::pluck('name', 'id'),
            'domaines' => \App\Models\Domaine::pluck('name', 'id'),
            'diplomes' => \App\Models\Diplome::pluck('name', 'id')
        ]);
    }

    public function metiersByDomaine(Request $request)
    {
        if ($request->domaine_id == null || $request->domaine_id == ""){
            return \App\Models\Metier::all();
        }
        return \App\Models\Metier::where('domaine_id',$request->domaine_id)->get();
    }

public function departementsByRegion(Request $request)
    {
        if($request->region_id == null || $request->region_id == ""){
            return \App\Models\Departement::all();
        }
        return \App\Models\Departement::where('region_id',$request->region_id)->get();
    }
    

  public function rechercher(Request $request)
{
    $query = Ouvrier::query();

    if ($request->filled('domaine_id')) {
        $query->whereHas('domaines', function ($q) use ($request) {
            $q->where('domaines.id', $request->domaine_id);
        });
    }

    if ($request->filled('metier_id')) {
        $query->whereHas('metiers', function ($q) use ($request) {
            $q->where('metiers.id', $request->metier_id);
        });
    }

    if ($request->filled('region_id')) {
        $query->where('region_id', $request->region_id);
    }

    if ($request->filled('departement_id')) {
        $query->where('departement_id', $request->departement_id);
    }

    if ($request->filled('phone_number')) {
        $query->where(
            'phone_number',
            'like',
            '%' . $request->phone_number . '%'
        );
    }

    $ouvriers = $query->with([
        'domaines',
        'metiers.domaine',
        'region',
        'departement',
        'country',
    ])->get();
    $metiers = \App\Models\Metier::all();
    $departements = \App\Models\Departement::all();
    $regions = \App\Models\Region::all();
    $domaines = \App\Models\Domaine::all();

    return view('ouvriers.ouvriers.index', ['ouvriers' => $ouvriers, 'departements' => $departements, 'metiers' => $metiers, 'regions' => $regions, 'domaines' => $domaines]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(OuvrierFormRequest $request)
    {
        $data = $request->validated();
        $uploadedImages = [];
        // $photoProfile = $request->validated('photo');
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $path = $image->store('ouvrier_profile', 'public');
            
            $data['photo'] = $path;
            // dd($data['photo']);
        }
        $data['user_id'] = Auth::user()->id;
        $ouvrier = \App\Models\Ouvrier::create($data);
        $ouvrier->diplomes()->sync($request->validated('diplomes'));
        $ouvrier->metiers()->sync($request->validated('metiers'));
        $ouvrier->domaines()->sync($request->validated('domaines'));
        
        $entrepriseIds = [];

        foreach ($request->entreprises as $name) {
            if($name != null){
                $entreprise = Entreprise::firstOrCreate([
                    'name' => $name,
                ]);
                $entrepriseIds[] = $entreprise->id;
            }
        }

        $ouvrier->entreprises()->sync($entrepriseIds);

        if($request->hasFile('images')){
            foreach ($request->file('images') as $image) {

            $path = $image->store('portfolios', 'public');

            $uploadedImages[] = $path;

            }
            if($uploadedImages != null){
                
                forEach($uploadedImages as $image){
                    \App\Models\Portfolio::create([
                        'image' => $image,
                        'ouvrier_id' => $ouvrier->id,
                    ]);
                }
            }
        }
        
        return redirect()->route('ouvriers.liste')->with('success', 'Ouvrier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ouvrier = \App\Models\Ouvrier::find($id)->load(['metiers.domaine', 'region', 'departement', 'country', 'portfolios']);
        // dd($ouvrier);        
        
        return view('ouvriers.ouvriers.show', compact('ouvrier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ouvrier = \App\Models\Ouvrier::findOrFail($id)->load(['region', 'departement', 'country', 'portfolios', 'entreprises']);
        $selectedDiplomes = $ouvrier->diplomes->pluck('id');
        $selectedmetiers = $ouvrier->metiers->pluck('id');
        $selectedDomaines = $ouvrier->domaines->pluck('id');
        $selectedCountry = $ouvrier->country->pluck('id');
        // dd($ouvrier);
        return view('ouvriers.ouvriers.edit', [
            'ouvrier' => $ouvrier,
            'countries' => \App\Models\Countries::pluck('name', 'id'),
            'regions' => \App\Models\Region::all(),
            'departements' => \App\Models\Departement::all(),
            'metiers' => \App\Models\Metier::pluck('name', 'id'),
            'domaines' => \App\Models\Domaine::pluck('name', 'id'),
            'diplomes' => \App\Models\Diplome::pluck('name', 'id'),
            // 'entreprises' => \App\Models\Entreprise::pluck('name', 'id'),
            'selectedDiplomes' => $selectedDiplomes,
            'selectedDomaines' => $selectedDomaines,
            'selectedMetiers' => $selectedmetiers,
            'selectedCountry' => $selectedCountry
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OuvrierUpdateFormRequest $request, string $id)
    {
        // dd($request->all());
        $dataOuvrier = $request->validated();
        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        $ouvrier->diplomes()->sync($dataOuvrier['diplomes']);
        $ouvrier->update($request->only('name', 'country_id', 'region_id', 'departement_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni','annees_experience', 'user_id'));
        $ouvrier->metiers()->sync($dataOuvrier['metiers']);
        $ouvrier->domaines()->sync($dataOuvrier['domaines']);
        $entrepriseIds = [];
        if($request->entreprises != null){
            foreach ($request->entreprises as $name) {
                if($name != null){
                    $entreprise = Entreprise::firstOrCreate([
                        'name' => $name,
                    ]);
                    $entrepriseIds[] = $entreprise->id;
                }
            }
            $ouvrier->entreprises()->sync($entrepriseIds);
        }
        if ($request->filled('deleted_entreprises')) {
            $ids = explode(',', $request->deleted_entreprises);
            // dd($ids);
            $ouvrier->entreprises()->detach($ids); // sync($ids);
        }
        $uploadedImages = [];

        if($request->hasFile('images')){
            foreach ($request->file('images') as $image) {

            $path = $image->store('portfolios', 'public');

            $uploadedImages[] = $path;

            }
            if($uploadedImages != null){
                
                forEach($uploadedImages as $image){
                    \App\Models\Portfolio::create([
                        'image' => $image,
                        'ouvrier_id' => $ouvrier->id,
                    ]);
                }
            }
        }
        
        
        return redirect()->route('ouvrier.show', $ouvrier->id)->with('success', 'Ouvrier updated successfully.');
    }


    public function get_mon_compte(Request $request)
    {
        $ouvrier = $request->validate(
        [
            'telephone' => 'required', 'string',
        ],

        [
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',

            'telephone.exists' => 'Ce numéro de téléphone n\'existe pas.',
        ]

);
        $ouvrier = \App\Models\Ouvrier::where('phone_number', $request->telephone)->orWhere('phone_number_2', $request->telephone)->first();
        if($request->telephone){
            return $this->show($ouvrier->id);
        }
        return view('dashboard', ['message' => "Ce numero est invalide"]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        $ouvrier->delete();

        return redirect()->route('ouvriers.liste')->with('success', 'Ouvrier deleted successfully.');
    }
}
