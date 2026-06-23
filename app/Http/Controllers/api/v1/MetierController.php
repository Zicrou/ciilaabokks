<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Metier;
use \App\Models\Domaine;

class MetierController extends Controller implements HasMiddleware
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
            'metiers' => Metier::with('domaine')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return [
            'domaines' => Domaine::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domaine_id' => 'required|exists:domaines,id',
        ]);

        Metier::create($request->only('name', 'domaine_id'));

        return ['message' => 'Metier created successfully.'];
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
        $metier = Metier::findOrFail($id)->load('domaine');
        return ['metier' => $metier, 'domaines' => Domaine::all()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domaine_id' => 'required|exists:domaines,id',
        ]);

        $metier = Metier::findOrFail($id);
        $metier->update($request->only('name', 'domaine_id'));

        return ['success' => 'Metier updated successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metier = Metier::findOrFail($id);
        $metier->delete();

        return ['success' => 'Metier deleted successfully.'];
    }
}
