@extends('layouts.app')

@section('head')
    @vite(['resources/js/farm-app.js'])
@endsection

@section('content')

    <div id="farm-app">
        <farm-page :farm="{{ $farm->toJson() }}"/>
    </div>
@endsection