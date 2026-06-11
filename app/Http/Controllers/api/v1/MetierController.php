<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
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
            'metiers' => \App\Models\Metier::with('domain')->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.metiers.create', [
            'domaines' => \App\Models\Domain::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domain,id',
        ]);

        \App\Models\Metier::create($request->only('name', 'domain_id'));

        return redirect()->route('metiers.index')->with('success', 'Metier created successfully.');
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
        $metier = \App\Models\Metier::findOrFail($id)->load('domain');
        return view('ouvriers.metiers.edit', ['metier' => $metier, 'domaines' => \App\Models\Domain::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domain,id',
        ]);

        $metier = \App\Models\Metier::findOrFail($id);
        $metier->update($request->only('name', 'domain_id'));

        return redirect()->route('metiers.index')->with('success', 'Metier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metier = \App\Models\Metier::findOrFail($id);
        $metier->delete();

        return redirect()->route('metiers.index')->with('success', 'Metier deleted successfully.');
    }
}
