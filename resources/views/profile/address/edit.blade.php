@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Edytuj adres</h3>
        </div>
        <div class="bg-white">
            <div class="row p-3">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('profile.address.update', $address) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
                    <div class="col-lg-6">
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $address->first_name }}" required autocomplete="first_name" autofocus>

                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
                    <div class="col-lg-6">
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $address->last_name }}" required autocomplete="last_name" autofocus>

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_name" class="col-lg-4 col-form-label text-lg-end">Nazwa firmy <small>(opcjonalne)</small></label>
                    <div class="col-lg-6">
                        <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $address->company_name }}" autocomplete="company_name" autofocus>

                        @error('company_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="street" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                    <div class="col-lg-6">
                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $address->street }}" required autocomplete="street">

                        @error('street')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                    <div class="col-lg-6">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $address->city }}" required autocomplete="city">

                        @error('city')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="zip_code" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                    <div class="col-lg-6">
                        <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ $address->zip_code }}" required autocomplete="zip_code">

                        @error('zip_code')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                    <div class="col-lg-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $address->phone }}" required autocomplete="phone">

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-4 offset-lg-4 d-grid">
                        <button type="submit" class="btn btn-primary text-white btn-">
                            Zapisz
                        </button>
                    </div>
                </div>
                <div><hr></div>
            </form>
        </div>
    </div>
@endsection
