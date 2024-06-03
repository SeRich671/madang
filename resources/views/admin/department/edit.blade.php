@extends('layouts.admin', ['menuName' => 'Edytuj dział ' . $department->name])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.department.update', $department) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mt-4 mb-3">
                <label for="name" class="col-lg-4 col-form-label text-lg-end">Nazwa</label>
                <div class="col-lg-4">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $department->name }}" required autocomplete="name">

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
                    <input id="subdomain" type="text" class="form-control @error('subdomain') is-invalid @enderror" name="subdomain" value="{{ $department->subdomain }}" required autocomplete="subdomain">

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
                            <option value="{{ $key }}" @selected($key === $department->status)>
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

            <div class="row">
                <div class="col-lg-12 text-center">
                    <img src="{{ asset('storage/' . $department->image) }}" style="max-width: 300px">
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <label for="image" class="col-lg-4 col-form-label text-lg-end">Obraz</label>
                <div class="col-lg-4">
                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image">
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
                        Zapisz
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
