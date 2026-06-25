<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use \App\Models\Region;
use \App\Models\Country;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Ouvrier;
use \App\Models\Portfolio;

class PortfolioController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')->except(['index' ,'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ouvrier = Ouvrier::findOrFail($request->id)->with('portfolios')->get();
        
        return  [
            'portfolios' => Portfolio::with('ouvrier')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  [
            'portfolios' => Portfolio::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'ouvrier_id' => 'required|exists:ouvriers,id',
        'images' => ['required', 'array'],
        'images.*' => [
            'required',
            'string',
            'regex:/\.(jpg|jpeg|png|webp)$/i',
            ],
        ]);
        $portfolio = "";
        
        $uploadedImages = [];
        
        foreach ($request->input('images') as $image) {
        //     // dd($image);

            // $path = $image->store('portfolios', 'public');

            $uploadedImages[] = $image;

        }
        if($uploadedImages != null){
            
            forEach($uploadedImages as $image){
                $portfolio = Portfolio::create([
                    'image' => $image,
                    'ouvrier_id' => $request->ouvrier_id,
                ]);
            }
        }

        return ['portfolios' => $portfolio, 'message' => 'Porfolio created successfully.'];
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
        $portfolio = Portfolio::findOrFail($id)->load('ouvrier');
        return ['portfolio' => $portfolio];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ouvrier_id' => 'required|exists:ouvrier,id',
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048']
        ]);

        $portfolio = Portfolio::findOrFail($id);
        if($request->images != null){
            $images = $request->images;
            forEach($images as $image){
                Portfolio::create([
                    'image' => $image,
                    'ouvrier_id' => $request->ouvrier_id,
                ]);
            }
        }

        return ['portfolio' => $portfolio, 'message' => 'Portfolio updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {   
        $user = $request->user();
        if(!$user){
            return "user not found";
        }
        if($id != ""){
            $ouvrier = Ouvrier::where('user_id', $user->id)->firstOrFail();
            $portfolio = Portfolio::where('id', $id)->where('ouvrier_id', $ouvrier->id)->firstOrFail();
            $portfolio->delete();
            return ['message' => 'Portfolio deleted successfully.'];
        }

        return ["message" => 'ouvrier id not found'];
    }
}
