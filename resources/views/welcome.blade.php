@extends('layouts.app')

@section('content')

    @if(!Auth::check())
        @include('parts.cta-register')
    @endif

    @include('parts.departments', ['departments' => $departments])
@endsection
