@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Rejestracja</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h5 class="text-primary">Dane konta</h5>
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="login" class="col-lg-4 col-form-label text-lg-end">Login</label>

                            <div class="col-lg-6">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" required autocomplete="login">

                                @error('login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-lg-4 col-form-label text-lg-end">Hasło</label>

                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h5 class="text-primary">Dane firmy</h5>
                                <hr>
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
                            <label for="company_name" class="col-lg-4 col-form-label text-lg-end">Nazwa firmy</label>
                            <div class="col-lg-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>

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
                                <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required autocomplete="nip" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

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
                                <input id="company_address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" required autocomplete="company_address">

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
                                <input id="company_city" type="text" class="form-control @error('company_city') is-invalid @enderror" name="company_city" value="{{ old('company_city') }}" required autocomplete="company_city">

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
                                <input id="company_zipcode" type="text" class="form-control @error('company_zipcode') is-invalid @enderror" name="company_zipcode" value="{{ old('company_zipcode') }}" required autocomplete="company_zipcode">

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
                                <input id="company_fax" type="text" class="form-control @error('company_fax') is-invalid @enderror" name="company_fax" value="{{ old('company_fax') }}" autocomplete="company_fax">

                                @error('company_fax')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h5 class="text-primary">Dane wysyłkowe</h5>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <span id="copy_addr" class="text-primary" style="cursor: pointer;">skopiuj dane firmy</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[first_name]" class="col-lg-4 col-form-label text-lg-end">Imię</label>
                            <div class="col-lg-6">
                                <input id="address[first_name]" type="text" class="form-control @error('address[first_name]') is-invalid @enderror" name="address[first_name]" value="{{ old('address[first_name]') }}" required autocomplete="address[first_name]" autofocus>

                                @error('address[first_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[last_name]" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
                            <div class="col-lg-6">
                                <input id="address[last_name]" type="text" class="form-control @error('address[last_name]') is-invalid @enderror" name="address[last_name]" value="{{ old('address[last_name]') }}" required autocomplete="address[last_name]" autofocus>

                                @error('address[last_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[company_name]" class="col-lg-4 col-form-label text-lg-end">Nazwa firmy<small>(opcjonalne)</small></label>
                            <div class="col-lg-6">
                                <input id="address[company_name]" type="text" class="form-control @error('address[company_name]') is-invalid @enderror" name="address[company_name]" value="{{ old('address[company_name]') }}" autocomplete="address[company_name]" autofocus>

                                @error('address[company_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[address]" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-6">
                                <input id="address[address]" type="text" class="form-control @error('address[address]') is-invalid @enderror" name="address[address]" value="{{ old('address[address]') }}" required autocomplete="address[address]">

                                @error('address[address]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[city]" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-6">
                                <input id="address[city]" type="text" class="form-control @error('address[city]') is-invalid @enderror" name="address[city]" value="{{ old('address[city]') }}" required autocomplete="address[city]">

                                @error('address[city]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address[zipcode]" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-6">
                                <input id="address[zipcode]" type="text" class="form-control @error('address[zipcode]') is-invalid @enderror" name="address[zipcode]" value="{{ old('address[zipcode]') }}" required autocomplete="address[zipcode]">

                                @error('address[zipcode]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 offset-lg-4">
                                <div class="form-check">
                                    <input type="checkbox" value="true" name="conditions" id="conditions" required="required" class="form-check-input ">

                                    <label for="conditions" class="form-check-label">
                                        Akceptuję <a class="text-primary" href="#">regulamin</a> i <a class="text-primary" href="#">politykę prywatności</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 offset-lg-4">
                                <div class="form-check">
                                    <input type="checkbox" value="true" name="marketing" id="marketing" class="form-check-input ">

                                    <label for="marketing" class="form-check-label">
                                        <small>(opcjonalne)</small> Wyrażam zgodę na używanie danych w celach marketingowych
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-lg-4 offset-lg-4 d-grid">
                                <button type="submit" class="btn btn-primary text-white btn-">
                                    Zarejestruj się
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#copy_addr').click(function () {
                $('input[name="address[first_name]"]').val($('input[name="first_name"]').val());
                $('input[name="address[last_name]"]').val($('input[name="last_name"]').val());
                $('input[name="address[company_name]"]').val($('input[name="company_name"]').val());
                $('input[name="address[address]"]').val($('input[name="company_address"]').val());
                $('input[name="address[city]"]').val($('input[name="company_city"]').val());
                $('input[name="address[zipcode]"]').val($('input[name="company_zipcode"]').val());
            });
        });
    </script>
@endpush
