@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Książka adresowa</h3>
        </div>

        <div class="bg-white p-3">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                @foreach($addresses as $address)
                    <div class="col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="card-title">
                                    {{ $address->company_name?: $address->first_name . ' ' . $address->last_name }}
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $address->street }}, {{ $address->city }}, {{ $address->zip_code }}
                            </div>
                            <div class="card-footer text-end">
                                <form method="POST" action="{{ route('profile.address.destroy', $address) }}">
                                <a href="{{ route('profile.address.edit', $address) }}" class="btn btn-outline-primary">Edytuj</a>
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
                                <a href="{{ route('profile.address.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
