@extends('layouts.admin', ['menuName' => 'Edytuj oddział ' . $branch->name])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.branch.update', $branch) }}">
            @csrf
            @method('PUT')
            <div class="row mt-4 mb-3">
                <label for="name" class="col-lg-4 col-form-label text-lg-end">Nazwa</label>
                <div class="col-lg-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $branch->name }}" required autocomplete="name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="email" class="col-lg-4 col-form-label text-lg-end">Email<small>(s)</small></label>
                <div class="col-lg-4">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $branch->email }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>
                <div class="col-lg-4">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $branch->phone }}" required autocomplete="phone">

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>
                <div class="col-lg-4">
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $branch->city }}" required autocomplete="city">

                    @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="street" class="col-lg-4 col-form-label text-lg-end">Adres</label>
                <div class="col-lg-4">
                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $branch->street }}" required autocomplete="street">

                    @error('street')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="zip_code" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>
                <div class="col-lg-4">
                    <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ $branch->zip_code }}" required autocomplete="zip_code">

                    @error('zip_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12 text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                        Powrót
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        Zapisz
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
