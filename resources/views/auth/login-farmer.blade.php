<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div id="farm-login-card">
        <Suspense>
            <farm-login login-route="{{ route('post-login-farmer') }}"/>
        </Suspense>
    </div>

</x-guest-layout>
