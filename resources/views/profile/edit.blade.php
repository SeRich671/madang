@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Edycja danych</h3>
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


            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h5 class="text-primary">Dane osobowe</h5>
                    <hr>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
                    <div class="col-lg-6">
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>

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
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>

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
                        <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $user->company_name }}" autocomplete="company_name" autofocus>

                        @error('company_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nip" class="col-lg-4 col-form-label text-lg-end">NIP</label>
                    <div class="col-lg-6">
                        <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ $user->nip }}" required autocomplete="nip" autofocus>

                        @error('nip')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>

                    <div class="col-lg-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                    <div class="col-lg-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone">

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                    <div class="col-lg-6">
                        <input id="company_address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ $user->company_address }}" required autocomplete="company_address">

                        @error('company_address')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                    <div class="col-lg-6">
                        <input id="company_city" type="text" class="form-control @error('company_city') is-invalid @enderror" name="company_city" value="{{ $user->company_city }}" required autocomplete="company_city">

                        @error('company_city')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                    <div class="col-lg-6">
                        <input id="company_zipcode" type="text" class="form-control @error('company_zipcode') is-invalid @enderror" name="company_zipcode" value="{{ $user->company_zipcode }}" required autocomplete="company_zipcode">

                        @error('company_zipcode')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_fax" class="col-lg-4 col-form-label text-lg-end">Fax <small>(opcjonalne)</small></label>

                    <div class="col-lg-6">
                        <input id="company_fax" type="text" class="form-control @error('company_fax') is-invalid @enderror" name="company_fax" value="{{ $user->company_fax }}" autocomplete="company_fax">

                        @error('company_fax')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-6 offset-lg-4">
                        <div class="form-check">
                            <input type="checkbox" value="1" name="marketing" id="marketing" class="form-check-input" @checked($user->marketing)>

                            <label for="marketing" class="form-check-label">
                                <small>(opcjonalne)</small> Otrzymywanie informacji o nowościach
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h5 class="text-primary">Edycja hasła <small>(opcjonalne)</small></h5>
                        <hr>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-lg-4 col-form-label text-lg-end">Nowe hasło</label>

                    <div class="col-lg-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-lg-4 col-form-label text-lg-end">Powtórz hasło</label>

                    <div class="col-lg-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-4 offset-lg-4 d-grid">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                            Powrót
                        </a>
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
