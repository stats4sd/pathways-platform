<?php

namespace App\Http\Controllers\Auth;

use App\Models\Farm;
use Illuminate\View\View;
use App\Models\FarmDetail;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\FarmerLoginRequest;

class AuthenticatedSessionFarmerController extends Controller
{
    public function create()
    {
        return view('auth.login-farmer');
    }

    public function store(FarmerLoginRequest $request)
    {
        $validated = $request->validated();

        // 1. Check farm code
        $farm = Farm::where('code', $validated['code'])->first();

        if (!$farm) {
            Alert::add('danger', "Aucun élevage trouvé avec ce code. Veuillez vérifier le code QR.")->flash();
            return back();
        }

        // 2. Check if phone number matches current farm phone number
        if ($farm->phone_number === $validated['phone_number']) {
            Auth::login($farm->user);
            return redirect('farm/' . $farm->id);
        }

        // 3. Check if phone number matches any historical number for the farm in farm details
        $matchInDetails = FarmDetail::where('farm_id', $farm->id)
            ->where('phone_number', $validated['phone_number'])
            ->exists();

        if ($matchInDetails) {
            Auth::login($farm->user);
            return redirect('farm/' . $farm->id);
        }

        // 4. If no match found
        Alert::add('danger', "Le code ou le numéro de téléphone est incorrect. Veuillez réessayer.")->flash();
        return back();

    }
}
