<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div id="farm-login-card">
        <Suspense>
            <farm-login
                login-route="{{ route('post-login') }}"
                :code-errors="{{json_encode($errors->get('code'))}}"
                :phone-number-errors="{{json_encode($errors->get('phone_number'))}}"
                old-phone-number="{{  old('phone_number_text') }}"

            />
        </Suspense>
    </div>

    <x-slot:alternateLogin>
        <a href="{{ route('login-researcher') }}"  class="btn btn-link">Connexion des chercheurs</a>
    </x-slot:alternateLogin>

</x-guest-layout>
