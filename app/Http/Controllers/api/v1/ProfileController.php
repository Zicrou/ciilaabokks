<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Ouvrier;

class ProfileController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(Request $request){
        $user = $request->user();
        if(!$user){
            return "User not found";
        }
        $ouvrier = Ouvrier::where('user_id', $user->id)
        ->with([
        'metiers.domaine',
        'region',
        'departement',
        'country',
        'entreprises',
        'portfolios'
    ])->first();
        $portfolios = "";
        return [
            'user' => $request->user(),
            'ouvrier_info' => $ouvrier,
            // 'portfolios' => $portfolios
        ];
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return [
            // 'user' => $request->user(),
        ];
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return ['status', 'profile-updated'];
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log out the user

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ['message' => "Profile deleted"];
    }
}
