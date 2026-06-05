<x-guest-layout>

    <h3>CEF-M</h3>
    <h5 class="mb-4">Connexion</h5>

    <form method="POST" action="{{ route('post-login-researcher') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">Adresse e-mail</label>

            <div class="col-md-8">
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>

            <div class="col-md-8">
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror" name="password"
                       required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        <div class="form-group d-flex justify-content-center flex-column">

            <div>
                <button type="submit" class="btn btn-primary mb-4">
                    Connexion
                </button>
            </div>

            <div class="form-check my-3">
                <input class="form-check-input" type="checkbox" name="remember"
                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    Se souvenir de moi
                </label>
            </div>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Mot de passe oublié?
                </a>
            @endif
        </div>

    </form>

    <x-slot:alternateLogin>
        <a href="{{ route('login') }}" class="btn btn-link">Yɛlen do a kan</a>
    </x-slot:alternateLogin>

</x-guest-layout>
