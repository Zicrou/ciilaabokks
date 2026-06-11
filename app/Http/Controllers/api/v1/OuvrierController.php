<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use PhpParser\Node\Stmt\Foreach_;

class OuvrierController extends Controller  implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    
    public function index()
    {   
        $departements = \App\Models\Departement::all();
        $metiers = \App\Models\Metier::all();
        $regions = \App\Models\Region::all();
        $domaines = \App\Models\Domain::all();
        $ouvriers = \App\Models\Ouvrier::with(['portfolio','metier.domain', 'region', 'departement', 'country'])->get();
        return  [
            'ouvriers' => $ouvriers,
            'departements' => $departements,
            'metiers' => $metiers,
            'regions' => $regions,
            'domaines' => $domaines,
        ];
    }

   

    public function metiersByDomaine(Request $request)
    {
        if ($request->domaine_id == null || $request->domaine_id == ""){
            return \App\Models\Metier::all();
        }
        return \App\Models\Metier::where(
            'domain_id',
            $request->domaine_id
        )->get();
    }

public function departementsByRegion(Request $request)
    {
        if($request->region_id == null || $request->region_id == ""){
            return \App\Models\Departement::all();
        }
        return \App\Models\Departement::where(
            'region_id',
            $request->region_id
        )->get();
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
    $query = \App\Models\Ouvrier::query();

    if ($request->filled('domain_id')) {
        $query->where('domain_id', $request->domain_id);
    }
    if ($request->filled('metier_id')) {
        $query->where('metier_id', $request->metier_id);
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
    $ouvriers = $query->with(['metier.domain', 'region', 'departement', 'country'])
    ->get();
    return ['ouvriers' => $ouvriers, 'ouvriersCount' => $ouvriers->count()];
    $metiers = \App\Models\Metier::all();
    $departements = \App\Models\Departement::all();
    $regions = \App\Models\Region::all();
    $domaines = \App\Models\Domain::all();
    return ['ouvriers' => $ouvriers, 'ouvriersCount' => $ouvriers->count(), 'departements' => $departements, 'metiers' => $metiers, 'domaines' => $domaines, 'regions' => $regions];
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
            'entreprises' => ['nullable', 'string', 'max:255'],
            'user_id' => ['uuid','nullable'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048']
        ]);

        $ouvrier = \App\Models\Ouvrier::create($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni','annees_experience', 'entreprises', 'user_id', 'portfolios'));
        $uploadedImages = [];

        foreach ($request->file('images') as $image) {

            $path = $image->store('portfolios', 'public');

            $uploadedImages[] = $path;

        }
        if($uploadedImages != null){
            
            forEach($uploadedImages as $image){
                Portfolio::create([
                    'image' => $image,
                    'ouvrier_id' => $ouvrier->id,
                ]);
            }
        }
        return $ouvrier;
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Ouvrier $ouvrier)
    {
        $ouvrier->load(['metier.domain', 'region', 'departement', 'country']);
        return $ouvrier;
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
            'entreprises' => ['nullable', 'string', 'max:255'],
            'user_id' => ['uuid','nullable'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048']
        ]);

        $ouvrier = \App\Models\Ouvrier::findOrFail($id);
        
        if(!$ouvrier->update($request->only('name', 'country_id', 'region_id', 'departement_id', 'metier_id', 'domain_id', 'date_of_birth', 'phone_number', 'email', 'address', 'phone_number_2', 'numero_cni', 'photo', 'photo_cni','annees_experience','entreprises', 'user_id'))){
            return ["message" => "Erreur update"];
        }
        if($request->images != null){
            $images = $request->images;
            forEach($images as $image){
                Portfolio::create([
                    'image' => $image,
                    'ouvrier_id' => $ouvrier->id,
                ]);
            }
        }
        return ["ouvrier" => $ouvrier, "status" => 200];
    }


    public function get_mon_compte(Request $request)
    {
        $ouvrier = $request->validate(
        [
            'telephone' => 'required|exists:ouvrier,phone_number',
        ],

        [
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',

            'telephone.exists' => 'Ce numéro de téléphone n\'existe pas.',
        ]

);
        // $ouvrier = \App\Models\Ouvrier::where('phone_number', $request->telephone)->orWhere('phone_number_2')->first();
        
        if($request->telephone){
            return $this->show($ouvrier['telephone']);
        }
        return ['message' => "Ce numero est invalide"];
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ouvrier = \App\Models\Ouvrier::findOrFail($id);

        $ouvrier->delete();

        return ['message' => 'Ouvrier deleted successfully.'];
    }
}
