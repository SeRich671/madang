@extends('layouts.admin', ['menuName' => 'Ustawienia strony'])

@section('content')
    <div class="row">
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
                    <button type="submit" class="btn btn-primary text-white">
                        Zapisz
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
