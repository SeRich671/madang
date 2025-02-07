@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Rejestracja</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Dane konta --}}
                            @include('auth.parts.register-account')

                            {{-- Dane firmy --}}
                            @include('auth.parts.register-company')

                            {{-- Dane wysyłkowe --}}
                            @include('auth.parts.register-shipping')

                            {{-- Zgody i regulaminy --}}
                            @include('auth.parts.register-agreements')

                            <div class="row mb-0">
                                <div class="col-lg-4 offset-lg-4 d-grid">
                                    <button type="submit" class="btn btn-primary text-white">
                                        Zarejestruj się
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#copy_addr').click(function () {
                $('input[name="address[first_name]"]').val($('input[name="first_name"]').val());
                $('input[name="address[last_name]"]').val($('input[name="last_name"]').val());
                $('input[name="address[company_name]"]').val($('input[name="company_name"]').val());
                $('input[name="address[address]"]').val($('input[name="company_address"]').val());
                $('input[name="address[city]"]').val($('input[name="company_city"]').val());
                $('input[name="address[zipcode]"]').val($('input[name="company_zipcode"]').val());
            });
        });
    </script>
@endpush
