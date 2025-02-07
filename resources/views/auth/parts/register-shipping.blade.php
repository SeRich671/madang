<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h5 class="text-primary">Dane wysyłkowe</h5>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <span id="copy_addr" class="text-primary" style="cursor: pointer;">skopiuj dane firmy</span>
    </div>
</div>

{{-- Imię odbiorcy --}}
<div class="row mb-3">
    <label for="address[first_name]" class="col-lg-4 col-form-label text-lg-end">Imię</label>
    <div class="col-lg-6">
        <input id="address[first_name]"
               type="text"
               class="form-control @error('address[first_name]') is-invalid @enderror"
               name="address[first_name]"
               value="{{ old('address[first_name]') }}"
               required
               autocomplete="address[first_name]"
               autofocus>
        <small class="text-muted">Imię odbiorcy przesyłki.</small>
        @error('address[first_name]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Nazwisko odbiorcy --}}
<div class="row mb-3">
    <label for="address[last_name]" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
    <div class="col-lg-6">
        <input id="address[last_name]"
               type="text"
               class="form-control @error('address[last_name]') is-invalid @enderror"
               name="address[last_name]"
               value="{{ old('address[last_name]') }}"
               required
               autocomplete="address[last_name]"
               autofocus>
        <small class="text-muted">Nazwisko odbiorcy przesyłki.</small>
        @error('address[last_name]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Nazwa firmy (opcjonalnie) --}}
<div class="row mb-3">
    <label for="address[company_name]" class="col-lg-4 col-form-label text-lg-end">
        Nazwa firmy <small>(opcjonalne)</small>
    </label>
    <div class="col-lg-6">
        <input id="address[company_name]"
               type="text"
               class="form-control @error('address[company_name]') is-invalid @enderror"
               name="address[company_name]"
               value="{{ old('address[company_name]') }}"
               autocomplete="address[company_name]"
               autofocus>
        <small class="text-muted">Nazwa firmy, jeśli wysyłka ma trafić do firmy.</small>
        @error('address[company_name]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Adres wysyłki --}}
<div class="row mb-3">
    <label for="address[address]" class="col-lg-4 col-form-label text-lg-end">Adres</label>
    <div class="col-lg-6">
        <input id="address[address]"
               type="text"
               class="form-control @error('address[address]') is-invalid @enderror"
               name="address[address]"
               value="{{ old('address[address]') }}"
               required
               autocomplete="address[address]">
        <small class="text-muted">Ulica i numer lokalu (np. ul. Dębowa 10/1).</small>
        @error('address[address]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Miasto wysyłki --}}
<div class="row mb-3">
    <label for="address[city]" class="col-lg-4 col-form-label text-lg-end">Miasto</label>
    <div class="col-lg-6">
        <input id="address[city]"
               type="text"
               class="form-control @error('address[city]') is-invalid @enderror"
               name="address[city]"
               value="{{ old('address[city]') }}"
               required
               autocomplete="address[city]">
        <small class="text-muted">Nazwa miasta, do którego mamy wysłać paczkę.</small>
        @error('address[city]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Kod pocztowy wysyłki --}}
<div class="row mb-3">
    <label for="address[zipcode]" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>
    <div class="col-lg-6">
        <input id="address[zipcode]"
               type="text"
               class="form-control @error('address[zipcode]') is-invalid @enderror"
               name="address[zipcode]"
               value="{{ old('address[zipcode]') }}"
               required
               autocomplete="address[zipcode]">
        <small class="text-muted">Kod pocztowy miejsca dostawy (np. 01-234).</small>
        @error('address[zipcode]')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
