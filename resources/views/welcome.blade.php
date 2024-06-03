@extends('layouts.app')

@section('content')

    @if(!Auth::check())
        @include('parts.cta-register')
    @endif

    @if(Auth::check() && !auth()->user()->branch_id)
        @include('parts.branch-required')
    @endif

    @include('parts.departments', ['departments' => $departments])
@endsection
