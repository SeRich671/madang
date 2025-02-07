<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h5 class="text-primary">Dane firmy</h5>
        <hr>
    </div>
</div>

{{-- Imię --}}
<div class="row mb-3">
    <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>
    <div class="col-lg-6">
        <input id="first_name"
               type="text"
               class="form-control @error('first_name') is-invalid @enderror"
               name="first_name"
               value="{{ old('first_name') }}"
               required
               autocomplete="first_name"
               autofocus>
        <small class="text-muted">Wpisz imię reprezentanta firmy.</small>
        @error('first_name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Nazwisko --}}
<div class="row mb-3">
    <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>
    <div class="col-lg-6">
        <input id="last_name"
               type="text"
               class="form-control @error('last_name') is-invalid @enderror"
               name="last_name"
               value="{{ old('last_name') }}"
               required
               autocomplete="last_name"
               autofocus>
        <small class="text-muted">Podaj nazwisko reprezentanta firmy.</small>
        @error('last_name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Nazwa firmy --}}
<div class="row mb-3">
    <label for="company_name" class="col-lg-4 col-form-label text-lg-end">Nazwa firmy</label>
    <div class="col-lg-6">
        <input id="company_name"
               type="text"
               class="form-control @error('company_name') is-invalid @enderror"
               name="company_name"
               value="{{ old('company_name') }}"
               required
               autocomplete="company_name"
               autofocus>
        <small class="text-muted">Wpisz pełną nazwę firmy (np. spółki).</small>
        @error('company_name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- NIP --}}
<div class="row mb-3">
    <label for="nip" class="col-lg-4 col-form-label text-lg-end">NIP</label>
    <div class="col-lg-6">
        <input id="nip"
               type="text"
               class="form-control @error('nip') is-invalid @enderror"
               name="nip"
               value="{{ old('nip') }}"
               required
               autocomplete="nip"
               autofocus>
        <small class="text-muted">Podaj numer NIP (bez kresek i spacji).</small>
        @error('nip')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Email --}}
<div class="row mb-3">
    <label for="email" class="col-lg-4 col-form-label text-lg-end">Email</label>
    <div class="col-lg-6">
        <input id="email"
               type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email"
               value="{{ old('email') }}"
               required
               autocomplete="email">
        <small class="text-muted">Podaj firmowy adres e-mail (np. kontakt@firma.pl).</small>
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Telefon --}}
<div class="row mb-3">
    <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>
    <div class="col-lg-6">
        <input id="phone"
               type="text"
               class="form-control @error('phone') is-invalid @enderror"
               name="phone"
               value="{{ old('phone') }}"
               required
               autocomplete="phone">
        <small class="text-muted">Wpisz numer telefonu kontaktowego (np. 123456789).</small>
        @error('phone')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Adres firmy --}}
<div class="row mb-3">
    <label for="company_address" class="col-lg-4 col-form-label text-lg-end">Adres</label>
    <div class="col-lg-6">
        <input id="company_address"
               type="text"
               class="form-control @error('company_address') is-invalid @enderror"
               name="company_address"
               value="{{ old('company_address') }}"
               required
               autocomplete="company_address">
        <small class="text-muted">Podaj ulicę i numer lokalu (np. ul. Klonowa 5/2).</small>
        @error('company_address')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Miasto firmy --}}
<div class="row mb-3">
    <label for="company_city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>
    <div class="col-lg-6">
        <input id="company_city"
               type="text"
               class="form-control @error('company_city') is-invalid @enderror"
               name="company_city"
               value="{{ old('company_city') }}"
               required
               autocomplete="company_city">
        <small class="text-muted">Podaj nazwę miejscowości (np. Warszawa).</small>
        @error('company_city')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Kod pocztowy firmy --}}
<div class="row mb-3">
    <label for="company_zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>
    <div class="col-lg-6">
        <input id="company_zipcode"
               type="text"
               class="form-control @error('company_zipcode') is-invalid @enderror"
               name="company_zipcode"
               value="{{ old('company_zipcode') }}"
               required
               autocomplete="company_zipcode">
        <small class="text-muted">Wpisz kod pocztowy (np. 00-001).</small>
        @error('company_zipcode')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Fax (opcjonalnie) --}}
<div class="row mb-3">
    <label for="company_fax" class="col-lg-4 col-form-label text-lg-end">
        Fax <small>(opcjonalne)</small>
    </label>
    <div class="col-lg-6">
        <input id="company_fax"
               type="text"
               class="form-control @error('company_fax') is-invalid @enderror"
               name="company_fax"
               value="{{ old('company_fax') }}"
               autocomplete="company_fax">
        <small class="text-muted">Numer faksu, jeśli firma nadal z takiego korzysta.</small>
        @error('company_fax')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
