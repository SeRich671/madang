@extends('layouts.admin', ['menuName' => 'Dodaj nowy dział'])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.department.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4 mb-3">
                <label for="name" class="col-lg-4 col-form-label text-lg-end">Nazwa</label>
                <div class="col-lg-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <label for="subdomain" class="col-lg-4 col-form-label text-lg-end">Subdomena</label>
                <div class="col-lg-4">
                    <input id="subdomain" type="text" class="form-control @error('subdomain') is-invalid @enderror" name="subdomain" value="{{ old('subdomain') }}" required autocomplete="subdomain">

                    @error('subdomain')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <label for="status" class="col-lg-4 col-form-label text-lg-end">Status</label>
                <div class="col-lg-4">
                    <select class="form-control" name="status" required>
                        @foreach($statuses as $key => $status)
                            <option value="{{ $key }}">
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
                <label for="image" class="col-lg-4 col-form-label text-lg-end">Obraz</label>
                <div class="col-lg-4">
                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required autocomplete="image">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-primary text-white">
                        Dodaj
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
