@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border-bottom border-primary bg-white p-3">
            <h3 class="text-primary">Dane do faktury</h3>
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
                @foreach($billings as $billing)
                    <div class="col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="card-title">
                                    {{ $billing->company_name?: $billing->first_name . ' ' . $billing->last_name }}
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $billing->address }}, {{ $billing->city }}, {{ $billing->zipcode }} <br>
                                {{ $billing->nip }} <br>
                                {{ $billing->email }}, {{ $billing->phone }}
                            </div>
                            <div class="card-footer text-end">
                                <form method="POST" action="{{ route('profile.billing.destroy', $billing) }}">
                                <a href="{{ route('profile.billing.edit', $billing) }}" class="btn btn-outline-primary">Edytuj</a>
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
                                <a href="{{ route('profile.billing.create') }}" class="btn btn-primary text-white">Dodaj nowe</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
