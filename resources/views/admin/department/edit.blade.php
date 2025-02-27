@extends('layouts.admin', ['menuName' => 'Edytuj dział ' . $department->name])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.department.update', $department) }}?page={{ request()->get('page') }}" enctype="multipart/form-data">
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
                <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>
                <div class="col-lg-4">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $department->email }}" required autocomplete="email">

                    @error('email')
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

            <div class="row mt-4 mb-3">
                <label for="footer_auth" class="col-lg-4 col-form-label text-lg-end">Stopka dla zalogowanych (HTML)</label>
                <div class="col-lg-4">
                    <textarea class="form-control" id="footer_auth" name="footer_auth" rows="10">{{ $department->footer_auth }}</textarea>
                    @error('footer_auth')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <label for="footer_guest" class="col-lg-4 col-form-label text-lg-end">Stopka dla gości (HTML)</label>
                <div class="col-lg-4">
                    <textarea class="form-control" id="footer_guest" name="footer_guest" rows="10">{{ $department->footer_guest }}</textarea>
                    @error('footer_guest')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6 offset-lg-4">
                    <div class="form-check">
                        <input type="hidden" name="show_contact" value="0">
                        <input type="checkbox" value="1" name="show_contact" id="show_contact" class="form-check-input" @checked($department->show_contact)>

                        <label for="show_contact" class="form-check-label">
                            Pokaż "Kontakt"
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6 offset-lg-4">
                    <div class="form-check">
                        <input type="hidden" name="show_change_department" value="0">
                        <input type="checkbox" value="1" name="show_change_department" id="show_change_department" class="form-check-input" @checked($department->show_change_department)>

                        <label for="show_change_department" class="form-check-label">
                            Pokaż "Zmień dział"
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

        <div class="row text-primary">
            <h5>Linki w menu głównym</h5>
            <hr>
        </div>

        <div class="row mt-4 mb-3">
            @foreach($department->links as $link)
                <div class="col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            {{ $link->name }}<br>
                            {{ $link->link }}
                        </div>
                        <div class="card-footer text-end">
                            <form method="POST" action="{{ route('admin.department.link.destroy', ['department' => $department, 'link' => $link]) }}">
                                <a href="{{ route('admin.department.link.edit', ['department' => $department, 'link' => $link]) }}" class="btn btn-outline-primary">Edytuj</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white">Usuń</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <a href="{{ route('admin.department.link.create', $department) }}" class="btn btn-primary text-white">Dodaj nowy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
