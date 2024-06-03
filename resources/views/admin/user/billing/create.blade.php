@extends('layouts.admin', ['menuName' => 'Tworzenie danych do faktury dla użytkownika ' . $user->first_name . ' ' . $user->last_name])

@section('content')
    <form method="POST" action="{{ route('admin.user.billing.store', $user) }}">
        @csrf
        @method('POST')

        <div class="row mb-3">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
            <div class="col-lg-6">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

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
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

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
                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" autocomplete="company_name" autofocus>

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
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

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
                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

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
                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" required autocomplete="zipcode">

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
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

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
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required autocomplete="nip">

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
@endsection
