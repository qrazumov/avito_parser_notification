@extends('layouts.vuelayout')

@section('content')
        <app
                username="{{ Auth::user()->name }}"
                routelogout="{{ route('logout') }}"
                scrf="{{ csrf_token() }}"
        ></app>
@endsection
