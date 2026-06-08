<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
class DomaineController extends Controller implements HasMiddleware
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
        return view('ouvriers.domaines.index', [
            'domaines' => \App\Models\Domain::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ouvriers.domaines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\Domain::create($request->only('name'));

        return redirect()->route('domaines.index')->with('success', 'Domaine created successfully.');
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
        $domaine = \App\Models\Domain::findOrFail($id);
        return view('ouvriers.domaines.edit', compact('domaine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $domaine = \App\Models\Domain::findOrFail($id);
        $domaine->update($request->only('name'));

        return redirect()->route('domaines.index')->with('success', 'Domaine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $domaine = \App\Models\Domain::findOrFail($id);
        $domaine->delete();

        return redirect()->route('domaines.index')->with('success', 'Domaine deleted successfully.');
    }
}
