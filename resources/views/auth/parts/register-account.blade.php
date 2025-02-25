<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h5 class="text-primary">Dane konta</h5>
        <hr>
    </div>
</div>

{{-- Email jako login --}}
<div class="row mb-3">
    <label for="login" class="col-lg-4 col-form-label text-lg-end">Email</label>
    <div class="col-lg-6">
        <input id="login"
               type="text"
               class="form-control @error('login') is-invalid @enderror"
               name="login"
               required
               autocomplete="login">
        <small class="text-muted">Wpisz unikalny email, którym będziesz się logować do systemu.</small>
        @error('login')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Hasło --}}
<div class="row mb-3">
    <label for="password" class="col-lg-4 col-form-label text-lg-end">Hasło</label>
    <div class="col-lg-6">
        <input id="password"
               type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               required
               autocomplete="new-password">
        <small class="text-muted">Użyj co najmniej 8 znaków, w tym cyfr i symboli, aby zwiększyć bezpieczeństwo.</small>
        @error('password')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Powtórzenie hasła --}}
<div class="row mb-3">
    <label for="password-confirm" class="col-lg-4 col-form-label text-lg-end">Powtórz hasło</label>
    <div class="col-lg-6">
        <input id="password-confirm"
               type="password"
               class="form-control"
               name="password_confirmation"
               required
               autocomplete="new-password">
        <small class="text-muted">Wpisz ponownie swoje hasło, aby uniknąć literówek.</small>
    </div>
</div>
