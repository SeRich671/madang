@extends('layouts.app')

@section('content')

    @if(session('error'))
        <div class="container">
            <div class="row my-2">
                <div class="col-lg-12 alert alert-danger">
                    Proszę o kontakt z firmą
                </div>
            </div>
        </div>
    @endif

    @if(!Auth::check())
        @include('parts.cta-register')
    @endif

    @if(Auth::check() && !auth()->user()->branch_id && auth()->user()->email_verified_at)
        @include('parts.branch-required')
    @endif
    @if(Auth::check() && !auth()->user()?->email_verified_at)
        @include('parts.verification-required')
    @endif

    @include('parts.departments', ['departments' => $departments])
@endsection
