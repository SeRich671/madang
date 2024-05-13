@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('order.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-lg-12">
                    <h2>Dostawa i płatność</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h3 class="text-primary">Adres dostawy</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="bg-white p-3">
                        <div class="row mb-4">
                            <label for="address_id" class="col-lg-4 col-form-label text-lg-end">Książka adresowa</label>

                            <div class="col-lg-4">
                                <select class="form-control @error('address_id') is-invalid @enderror" name="address_id">
                                    <option value="" selected>--wybierz--</option>
                                    @foreach($addresses as $address)
                                        <option value="{{ json_encode($address) }}">
                                            {{ $address->city }}, {{ $address->street }}, {{ $address->zip_code }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('address_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4 mb-3">
                            <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>

                            <div class="col-lg-4">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

                            <div class="col-lg-4">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="company_name" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

                            <div class="col-lg-4">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

                                @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-4">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-4">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-4">
                                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" required autocomplete="zipcode">

                                @error('zipcode')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h3 class="text-primary">Uwagi do zamówienia</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="bg-white p-3">
                    <textarea id="description" name="description" class="form-control @error('phone') is-invalid @enderror" rows="10">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="border-bottom border-primary bg-white p-3">
                        <h3 class="text-primary">Twoje zamówienie będą realizowały oddziały</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="bg-white p-3">
                        @foreach($cartItems->groupBy('branch_id') as $branchId => $branchProducts)
                            <h5>{{ \App\Models\Branch::find($branchId)->name }}</h5>
                            <hr>
                            <table class="table table-responsive table-striped text-center">
                                <thead>
                                <tr>
                                    <th>Nazwa produktu</th>
                                    <th>Ilość opakowań</th>
                                    <th>Szt. w opakowaniu</th>
                                    <th>Razem szt.</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($branchProducts as $cartItem)
                                    <tr>
                                        <td class="col-lg-3">{{ $cartItem->product->name }}</td>
                                        <td class="col-lg-3">{{ $cartItem->quantity }}</td>
                                        <td class="col-lg-3">{{ $cartItem->product->count_in_package }}</td>
                                        <td class="col-lg-3">{{ $cartItem->product->count_in_package * $cartItem->quantity }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <div class="row mb-3">
                                    <label for="delivery" class="col-lg-4 col-form-label text-lg-end">Sposób dostawy</label>

                                    <div class="col-lg-4">
                                        <select class="form-control @error('delivery') is-invalid @enderror" name="delivery[{{ $branchId }}]" required>
                                            <option value="" selected disabled>--wybierz--</option>
                                            @foreach(\App\Enums\Order\DeliveryEnum::getValues() as $delivery)
                                                <option value="{{ $delivery }}">
                                                    {{ \App\Enums\Order\DeliveryEnum::getDescription($delivery) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('delivery')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="payment" class="col-lg-4 col-form-label text-lg-end">Sposób dostawy</label>

                                    <div class="col-lg-4">
                                        <select class="form-control @error('payment') is-invalid @enderror" name="payment[{{ $branchId }}]" required>
                                            <option value="" selected disabled>--wybierz--</option>
                                            @foreach(\App\Enums\Order\PaymentEnum::getValues() as $payment)
                                                <option value="{{ $payment }}">
                                                    {{ \App\Enums\Order\PaymentEnum::getDescription($payment) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('payment')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="bg-white text-end p-3">
                        <button type="submit" class="btn btn-primary text-white">Podsumowanie</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function () {
           $('select[name="address_id"]').change(function () {
               if($('select[name="address_id"]').val() != 0) {
                   let data = JSON.parse($('select[name="address_id"]').val());

                   $('input[name="first_name"]').val(data['first_name']);
                   $('input[name="last_name"]').val(data['last_name']);
                   $('input[name="company_name"]').val(data['company_name']);
                   $('input[name="address"]').val(data['street']);
                   $('input[name="city"]').val(data['city']);
                   $('input[name="zipcode"]').val(data['zip_code']);
                   $('input[name="phone"]').val(data['phone']);
               }else{
                   $('input[name="first_name"]').val('');
                   $('input[name="last_name"]').val('');
                   $('input[name="company_name"]').val('');
                   $('input[name="address"]').val('');
                   $('input[name="city"]').val('');
                   $('input[name="zipcode"]').val('');
                   $('input[name="phone"]').val('');
               }

           })
        });
    </script>
@endpush
