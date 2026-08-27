<?php

namespace App\Http\Controllers\Auth;

use App\Models\Farm;
use App\Models\FarmDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\FarmerLoginRequest;

class AuthenticatedSessionFarmerController extends Controller
{
    public function create()
    {
        return view('auth.login-farmer');
    }

    /**
     * Check whether a scanned QR code matches a farm,
     * so the front-end can reject bad codes before step 2.
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $exists = Farm::where('code', $request->input('code'))->exists();

        if (! $exists) {
            return response()->json(['message' => 'Invalid QR code'], 422);
        }

        return response()->json(['message' => 'OK']);
    }

    public function store(FarmerLoginRequest $request)
    {
        $validated = $request->validated();

        $code = $validated['code'];
        $phone = $validated['phone_number'];

        $farm = Farm::where('code', $code)->first();

        // 1. Code is invalid
        if (! $farm) {
            return back()
                ->withErrors([
                    'code' => 'Cikɛda numerɔ talenɲi ma lakodon. A sɛgɛ-sɛgɛ kaɲɛ, ni ka lajɛ tuguni.',
                ])
                ->withInput()
                ->with('farm_step', 1);
        }

        // 2. Phone matches current farm phone
        if ($farm->phone_number === $phone) {
            return $this->loginToFarm($farm);
        }

        // 3. Phone matches historical phone numbers for this farm
        $matchInDetails = FarmDetail::where('farm_id', $farm->id)
            ->where('phone_number', $phone)
            ->exists();

        if ($matchInDetails) {
            return $this->loginToFarm($farm);
        }

        // 4. Phone does not match current or historical numbers for this farm
        return back()
            ->withErrors([
                'phone_number' => 'Nimɔrɔ ma bɛn, aw ka nimɔrɔ bɛnnen don.',
            ])
            ->withInput()
            ->with([
                'farm_step' => 2,
                'scanned_code' => $code,
            ]);
    }

    private function loginToFarm(Farm $farm)
    {
        // some farms may not have a linked user account yet
        if (! $farm->user) {
            return back()
                ->withErrors([
                    'code' => "Ce compte n'est pas encore activé. Veuillez contacter l'équipe.",
                ])
                ->withInput()
                ->with('farm_step', 1);
        }

        Auth::login($farm->user);

        request()->session()->regenerate();

        return redirect('farm/' . $farm->id);
    }
}
