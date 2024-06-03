@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Edytuj adres</h3>
        </div>
        <div class="bg-white p-3">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('profile.billing.update', $billing) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
                    <div class="col-lg-6">
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $billing->first_name }}" required autocomplete="first_name" autofocus>

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
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $billing->last_name }}" required autocomplete="last_name" autofocus>

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
                        <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $billing->company_name }}" autocomplete="company_name" autofocus>

                        @error('company_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                    <div class="col-lg-6">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $billing->address }}" required autocomplete="address">

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                    <div class="col-lg-6">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $billing->city }}" required autocomplete="city">

                        @error('city')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                    <div class="col-lg-6">
                        <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ $billing->zipcode }}" required autocomplete="zipcode">

                        @error('zipcode')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                    <div class="col-lg-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $billing->phone }}" required autocomplete="phone">

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>

                    <div class="col-lg-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $billing->email }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nip" class="col-lg-4 col-form-label text-lg-end">NIP</label>

                    <div class="col-lg-6">
                        <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ $billing->nip }}" required autocomplete="nip">

                        @error('nip')
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
            </form>
        </div>
    </div>
@endsection
