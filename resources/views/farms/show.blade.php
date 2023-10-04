@extends('backpack::layouts.plain')

@section('content')

    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Research Team'))
        <a class="btn btn-link" href="{{ url('admin') }}">Retour au panneau d'administration</a>
    @endif

    <div class="pl-2">

        <div class="card" style="min-width: 300px">
            <div class="card-header">
                <h1>{{ $farm->chef_upa }}</h1>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div>~~~ beaucoup d'informations ~~~<br/>~~~ intéressantes vont ici ~~~</div>
            </div>
        </div>

        <form method="POST" action={{ route('logout') }}>
            @csrf
            <button class="btn btn-info" type="submit"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}
            </button>
        </form>
    </div>

@endsection
