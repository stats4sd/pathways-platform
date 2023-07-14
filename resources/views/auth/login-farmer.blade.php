<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div id="farm-login-card">
        <Suspense>
            <farm-login login-route="{{ route('post-login') }}"/>
        </Suspense>
    </div>

    <x-slot:alternateLogin>
        <a href="{{ route('login-researcher') }}"  class="btn btn-link">Login as Researcher</a>
    </x-slot:alternateLogin>

</x-guest-layout>
