@extends('layouts.admin', ['menuName' => 'Tworzenie użytkownika'])

@section('content')
    <form method="POST" action="{{ route('admin.user.store') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="login" class="col-lg-4 col-form-label text-lg-end">Login</label>
            <div class="col-lg-4">
                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login">
                @error('login')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>
            <div class="col-lg-4">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
            <div class="col-lg-4">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" name="first_name" required autocomplete="first_name">
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
            <div class="col-lg-4">
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" name="last_name" required autocomplete="last_name">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="status" class="col-lg-4 col-form-label text-lg-end">Status</label>
            <div class="col-lg-4">
                <select class="form-control" name="status" required>
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" @selected($key == old('status'))>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-3">
            <label for="role" class="col-lg-4 col-form-label text-lg-end">Role</label>
            <div class="col-lg-4">
                <select class="form-control" name="role" required>
                    @foreach($roles as $key => $role)
                        <option value="{{ $key }}" @selected($key == old('rold'))>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="branch_id" class="col-lg-4 col-form-label text-lg-end">Oddział</label>
            <div class="col-lg-4">
                <select class="form-control" name="branch_id" required>
                    @foreach($branches as $key => $branch)
                        <option value="{{ $key }}" @selected($key == old('branch_id'))>
                            {{ $branch }}
                        </option>
                    @endforeach
                </select>
                @error('branch_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="uncertain" value="0">
                    <input type="checkbox" value="1" name="uncertain" id="uncertain" class="form-check-input" @checked(old('uncertain'))>

                    <label for="uncertain" class="form-check-label">
                        <small>(opcjonalne)</small> Niepewny
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 offset-lg-4">
                <div class="form-check">
                    <input type="hidden" name="marketing" value="0">
                    <input type="checkbox" value="1" name="marketing" id="marketing" class="form-check-input" @checked(old('marketing'))>

                    <label for="marketing" class="form-check-label">
                        <small>(opcjonalne)</small> Zgody marketingowe
                    </label>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="password" class="col-lg-4 col-form-label text-lg-end">Hasło</label>
            <div class="col-lg-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <label for="password_confirmation" class="col-lg-4 col-form-label text-lg-end">Potwierdź hasło</label>
            <div class="col-lg-4">
                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required name="password_confirmation" autocomplete="password_confirmation">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-12 mt-4 text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                Powrót
            </a>
            <button class="btn btn-primary text-white">
                Zapisz
            </button>
        </div>
    </form>
@endsection
