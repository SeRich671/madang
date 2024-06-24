@extends('layouts.admin', ['menuName' => 'Tworzenie linku dla ' . $department->name])

@section('content')
    <form method="POST" action="{{ route('admin.department.link.store', $department) }}">
        @csrf
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
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="link">Link</label>
                <input type="text" class="form-control" name="link" value="{{ old('link') }}" required>
            </div>
            <div class="col-lg-12 mt-4 text-end">
                <button class="btn btn-primary text-white">
                    Zapisz
                </button>
            </div>
        </div>
    </form>
@endsection
