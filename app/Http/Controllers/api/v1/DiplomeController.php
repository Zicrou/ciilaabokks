<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use \App\Models\Diplome;
class DiplomeController extends Controller implements HasMiddleware
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
            'diplomes' => Diplome::all()
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

        Diplome::create($request->only('name'));

        return ['message' => 'Diplome created successfully.'];
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
        $diplomes = Diplome::findOrFail($id);
        return ['diplomes' => $diplomes];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $diplomes = Diplome::findOrFail($id);
        $diplomes->update($request->only('name'));

        return ['success' => 'Diplome updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diplomes = Diplome::findOrFail($id);
        $diplomes->delete();

    return ['success' => 'Diplome deleted successfully.'];
    }
}
