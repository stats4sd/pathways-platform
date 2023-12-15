@extends('backpack::layouts.plain')

@section('after_scripts')
    @vite(['resources/css/app.css', 'resources/js/farm-app.js'])
@endsection

@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Research Team'))
        <a class="btn btn-link" href="{{ url('admin') }}">Retour au panneau d'administration</a>
    @endif

    <div id="farm-app">
        <farm-app
            :farm="{{ $farm->toJson() }}" 
            logout-route="{{ route('logout') }}"
        />
    </div>

@endsection
