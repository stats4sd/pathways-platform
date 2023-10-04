<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FarmerLoginRequest;
use App\Models\Farm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Prologue\Alerts\Facades\Alert;

class AuthenticatedSessionFarmerController extends Controller
{
    public function create()
    {
        return view('auth.login-farmer');
    }

    public function store(FarmerLoginRequest $request)
    {
        $validated = $request->validated();

        $farm = Farm::where('code', $validated['code'])
            ->where('phone_number', $validated['phone_number'])
            ->first();

        if($farm) {
            Auth::login($farm->user);
        } else {
            Alert::add('danger', "Le code scanné n'a pas été reconnu. Veuillez réessayer ou vérifier que vous utilisez le bon code QR.")->flash();
            return back();
        }

        return redirect('/admin/farm/' . $farm->id . '/show');
    }
}
