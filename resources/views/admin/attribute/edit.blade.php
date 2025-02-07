@extends('layouts.admin', ['menuName' => 'Edytuj cechę produktu  ' . $attribute->name])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.attribute.update', $attribute) }}">
            @csrf
            @method('PUT')
            <div class="row mt-4 mb-3">
                <label for="name" class="col-lg-4 col-form-label text-lg-end">Nazwa</label>
                <div class="col-lg-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $attribute->name }}" required autocomplete="name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-6 offset-lg-4">
                    <div class="form-check">
                        <input type="hidden" name="is_filter" value="0">
                        <input type="checkbox" value="1" name="is_filter" id="is_filter" class="form-check-input" @checked($attribute->is_filter)>

                        <label for="is_filter" class="form-check-label">
                            Pokaż w filtrach
                        </label>
                    </div>
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
