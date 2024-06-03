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
