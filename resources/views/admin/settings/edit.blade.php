@extends('layouts.admin', ['menuName' => 'Ustawienia strony'])

@section('content')
    <div class="row">
        <div class="col-lg-12 text-end">
            @if(session('error'))

            @endif
            <form id="mailingForm" action="{{ route('admin.sendMailing') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success text-white">
                    Wyślij Mailing
                </button>
            </form>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')
            <div class="row mt-4 mb-3">
                <label for="per_page" class="col-lg-4 col-form-label text-lg-end">Domyślna ilość elementów na stronie</label>
                <div class="col-lg-4">
                    <select class="form-control" name="per_page">
                        <option value="12" @selected(cache()->get('settings.per_page') == '12')>12</option>
                        <option value="24" @selected(cache()->get('settings.per_page') == '24')>24</option>
                        <option value="36" @selected(cache()->get('settings.per_page') == '36')>36</option>
                        <option value="48" @selected(cache()->get('settings.per_page') == '48')>48</option>
                        <option value="60" @selected(cache()->get('settings.per_page') == '60')>60</option>
                    </select>

                    @error('per_page')
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

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#mailingForm').submit(function (e) {
                if (!confirm('Czy na pewno chcesz wysłać mailing do użytkowników?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
