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
                        <h3 class="text-primary">Faktura i dostawa</h3>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0">
                    <div class="bg-white p-3 h-100">
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
                            <label for="address[first_name]" class="col-lg-4 col-form-label text-lg-end">Imię</label>

                            <div class="col-lg-4">
                                <input id="address[first_name]" type="text" class="form-control @error('address[first_name]') is-invalid @enderror" name="address[first_name]" value="{{ old('address[first_name]') }}" required autocomplete="address[first_name]">

                                @error('address[first_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[last_name]" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

                            <div class="col-lg-4">
                                <input id="address[last_name]" type="text" class="form-control @error('address[last_name]') is-invalid @enderror" name="address[last_name]" value="{{ old('address[last_name]') }}" required autocomplete="address[last_name]">

                                @error('address[last_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[company_name]" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

                            <div class="col-lg-4">
                                <input id="address[company_name]" type="text" class="form-control @error('address[company_name]') is-invalid @enderror" name="address[company_name]" value="{{ old('address[company_name]') }}" required autocomplete="address[company_name]">

                                @error('address[company_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[address]" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-4">
                                <input id="address[address]" type="text" class="form-control @error('address[address]') is-invalid @enderror" name="address[address]" value="{{ old('address[address]') }}" required autocomplete="address[address]">

                                @error('address[address]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[city]" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-4">
                                <input id="address[city]" type="text" class="form-control @error('address[city]') is-invalid @enderror" name="address[city]" value="{{ old('address[city]') }}" required autocomplete="address[city]">

                                @error('address[city]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[zipcode]" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-4">
                                <input id="address[zipcode]" type="text" class="form-control @error('address[zipcode]') is-invalid @enderror" name="address[zipcode]" value="{{ old('address[zipcode]') }}" required autocomplete="address[zipcode]">

                                @error('address[zipcode]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address[phone]" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="address[phone]" type="text" class="form-control @error('address[phone]') is-invalid @enderror" name="address[phone]" value="{{ old('address[phone]') }}" required autocomplete="address[phone]">

                                @error('address[phone]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ps-lg-0">
                    <div class="bg-white p-3">
                        <div class="row mb-4">
                            <label for="billing_id" class="col-lg-4 col-form-label text-lg-end">Dane do faktury</label>

                            <div class="col-lg-4">
                                <select class="form-control @error('billing_id') is-invalid @enderror" name="billing_id">
                                    <option value="" selected>--wybierz--</option>
                                    @foreach($billings as $billing)
                                        <option value="{{ json_encode($billing) }}">
                                            {{ $billing->nip }}, {{ $billing->email }}, {{ $billing->phone }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('billing_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4 mb-3">
                            <label for="billing[first_name]" class="col-lg-4 col-form-label text-lg-end">Imię</label>

                            <div class="col-lg-4">
                                <input id="billing[first_name]" type="text" class="form-control @error('billing[first_name]') is-invalid @enderror" name="billing[first_name]" value="{{ old('billing[first_name]') }}" required autocomplete="billing[first_name]">

                                @error('billing[first_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[last_name]" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

                            <div class="col-lg-4">
                                <input id="billing[last_name]" type="text" class="form-control @error('billing[last_name]') is-invalid @enderror" name="billing[last_name]" value="{{ old('billing[last_name]') }}" required autocomplete="billing[last_name]">

                                @error('billing[last_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[company_name]" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

                            <div class="col-lg-4">
                                <input id="billing[company_name]" type="text" class="form-control @error('billing[company_name]') is-invalid @enderror" name="billing[company_name]" value="{{ old('billing[company_name]') }}" required autocomplete="billing[company_name]">

                                @error('billing[company_name]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[address]" class="col-lg-4 col-form-label text-lg-end">Adres</label>

                            <div class="col-lg-4">
                                <input id="billing[address]" type="text" class="form-control @error('billing[address]') is-invalid @enderror" name="billing[address]" value="{{ old('billing[address]') }}" required autocomplete="billing[address]">

                                @error('billing[address]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[city]" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

                            <div class="col-lg-4">
                                <input id="billing[city]" type="text" class="form-control @error('billing[city]') is-invalid @enderror" name="billing[city]" value="{{ old('billing[city]') }}" required autocomplete="billing[city]">

                                @error('billing[city]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[zipcode]" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

                            <div class="col-lg-4">
                                <input id="billing[zipcode]" type="text" class="form-control @error('billing[zipcode]') is-invalid @enderror" name="billing[zipcode]" value="{{ old('billing[zipcode]') }}" required autocomplete="billing[zipcode]">

                                @error('billing[zipcode]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="billing[phone]" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="billing[phone]" type="text" class="form-control @error('billing[phone]') is-invalid @enderror" name="billing[phone]" value="{{ old('billing[phone]') }}" required autocomplete="billing[phone]">

                                @error('billing[phone]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="billing[email]" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="billing[email]" type="email" class="form-control @error('billing[email]') is-invalid @enderror" name="billing[email]" value="{{ old('billing[email]') }}" required autocomplete="billing[email]">

                                @error('billing[email]')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="billing[nip]" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

                            <div class="col-lg-4">
                                <input id="billing[nip]" type="text" class="form-control @error('billing[nip]') is-invalid @enderror" name="billing[nip]" value="{{ old('billing[nip]') }}" required autocomplete="billing[nip]">

                                @error('billing[nip]')
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

                   $('input[name="address[first_name]"]').val(data['first_name']);
                   $('input[name="address[last_name]"]').val(data['last_name']);
                   $('input[name="address[company_name]"]').val(data['company_name']);
                   $('input[name="address[address]"]').val(data['street']);
                   $('input[name="address[city]"]').val(data['city']);
                   $('input[name="address[zipcode]"]').val(data['zip_code']);
                   $('input[name="address[phone]"]').val(data['phone']);
               }else{
                   $('input[name="address[first_name]"]').val('');
                   $('input[name="address[last_name]"]').val('');
                   $('input[name="address[company_name]"]').val('');
                   $('input[name="address[address]"]').val('');
                   $('input[name="address[city]"]').val('');
                   $('input[name="address[zipcode]"]').val('');
                   $('input[name="address[phone]"]').val('');
               }
           })

            $('select[name="billing_id"]').change(function () {
                if($('select[name="billing_id"]').val() != 0) {
                    let data = JSON.parse($('select[name="billing_id"]').val());

                    $('input[name="billing[first_name]"]').val(data['first_name']);
                    $('input[name="billing[last_name]"]').val(data['last_name']);
                    $('input[name="billing[company_name]"]').val(data['company_name']);
                    $('input[name="billing[address]"]').val(data['address']);
                    $('input[name="billing[city]"]').val(data['city']);
                    $('input[name="billing[zipcode]"]').val(data['zipcode']);
                    $('input[name="billing[phone]"]').val(data['phone']);
                    $('input[name="billing[email]"]').val(data['email']);
                    $('input[name="billing[nip]"]').val(data['nip']);
                }else{
                    $('input[name="billing[first_name]"]').val('');
                    $('input[name="billing[last_name]"]').val('');
                    $('input[name="billing[company_name]"]').val('');
                    $('input[name="billing[address]"]').val('');
                    $('input[name="billing[city]"]').val('');
                    $('input[name="billing[zipcode]"]').val('');
                    $('input[name="billing[phone]"]').val('');
                    $('input[name="billing[email]"]').val('');
                    $('input[name="billing[nip]"]').val('');
                }
            })
        });
    </script>
@endpush
