<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use \App\Models\Region;
use \App\Models\Country;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller implements HasMiddleware
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
        return  [
            'portfolios' => \App\Models\Portfolio::with('ouvrier')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  [
            'portfolios' => \App\Models\Portfolio::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ouvrier_id' => 'required|exists:ouvrier,id',
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048']
        ]);

        $portfolio = "";
        
         $uploadedImages = [];

        foreach ($request->file('images') as $image) {

            $path = $image->store('portfolios', 'public');

            $uploadedImages[] = $path;

        }
        if($uploadedImages != null){
            
            forEach($uploadedImages as $image){
                $portfolio = \App\Models\Portfolio::create([
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
        $portfolio = \App\Models\Portfolio::findOrFail($id)->load('ouvrier');
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

        $portfolio = \App\Models\Portfolio::findOrFail($id);
        if($request->images != null){
            $images = $request->images;
            forEach($images as $image){
                \App\Models\Portfolio::create([
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
    public function destroy(string $id)
    {
        $portfolio = \App\Models\Portfolio::findOrFail($id);
        $portfolio->delete();

        return ['message' => 'Region deleted successfully.'];
    }
}
