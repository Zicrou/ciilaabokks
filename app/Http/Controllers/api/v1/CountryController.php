<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
// use Laravel\Sanctum\PersonalAccessToken;
// use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;

// use Illuminate\Routing\Controllers\HasMiddleware;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
// use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\PersonalAccessToken;
use \App\Models\Countries;
class CountryController extends Controller implements HasMiddleware
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
        return [
            'countries' => Countries::all()
        ];
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Countries::create($request->only('name'));

        return ['message' => 'Country created successfully.'];
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
        $country = Countries::findOrFail($id);
        return ['country' => $country];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country = Countries::findOrFail($id);
        $country->update($request->only('name'));

        return ['message' => 'Country updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Countries::findOrFail($id);
        $country->delete();

        return ['message' => 'Country deleted successfully.'];
    }
}
