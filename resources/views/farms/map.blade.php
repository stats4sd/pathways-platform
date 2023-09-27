@extends('layouts.app')
@extends(backpack_view('blank'))


@section('head')
    @vite(['resources/css/app.css', 'resources/js/farm-app.js'])
@endsection

@section('content')

    <div id="farm-app">
        <farm-page :farm="{{ $farm->toJson() }}"/>
    </div>
@endsection