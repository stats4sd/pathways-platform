@extends(backpack_view('blank'))


@section('after_scripts')
    @vite(['resources/css/app.css', 'resources/js/farm-admin.js'])
@endsection

@section('content')

    <div class="d-flex justify-content-between mt-4 pt-4">
        <h1>Carte UPA {{ $farm->code }}</h1>
    </div>

    <p class="mb-4 ms-2 ml-2">
        <small><a href="{{ '/admin/farm' }}" class="font-sm">
        <i class="la la-angle-double-left"></i>
        Retour à la liste UPAs</span></a></small>
    </p>

    <div id="farm-admin">
        <farm-page :farm="{{ $farm->toJson() }}"/>
    </div>
@endsection