@extends('layouts.admin', ['menuName' => 'Edycja linku ' . $link->name])

@section('content')
    <form method="POST" action="{{ route('admin.department.link.update', ['department' => $department, 'link' => $link]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="name">Nazwa</label>
                <input type="text" class="form-control" name="name" value="{{ $link->name }}" required>
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="link">Nazwa</label>
                <input type="text" class="form-control" name="link" value="{{ $link->link }}" required>
            </div>
            <div class="col-lg-12 mt-4 text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                    Powrót
                </a>
                <button class="btn btn-primary text-white">
                    Zapisz
                </button>
            </div>
        </div>
    </form>
@endsection
