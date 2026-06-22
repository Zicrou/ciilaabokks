<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use \App\Models\Region;
use \App\Models\Country;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Countries;

class RegionController extends Controller implements HasMiddleware
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
            'regions' => Region::with('country')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  [
            'countries' => Countries::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'country_id' => ['required','exists:countries,id'],
        ]);

        $region = Region::create($request->only('name', 'country_id'));

        return ['region' => $region, 'message' => 'Region created successfully.'];
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
        $region = Region::findOrFail($id)->load('country');
        return ['region' => $region, 'countries' => Countries::all()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $region = Region::findOrFail($id);
        $region->update($request->only('name', 'country_id'));

        return ['region' => $region, 'success' => 'Region updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return ['success' => 'Region deleted successfully.'];
    }
}
