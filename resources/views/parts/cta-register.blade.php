<div class="container">
    <div class="row d-flex align-items-center bg-white py-3">
        <div class="d-none d-lg-block col-lg-1">
            <img src="{{ asset('icons/campaign-24px.svg') }}" width="48px" height="48px">
        </div>

        <div class="col-lg-5 pb-3 pb-lg-0">
            <div class="text-uppercase">
                <strong class="fw-bold">Witamy na stronie madang.pl</strong>
            </div>
            <div>
                Aby złożyć zamówienie,
                <a class="link-primary" href="{{ route('login') }}">zaloguj się </a> lub
                <a class="link-primary" href="{{ route('register') }}">zarejestruj konto</a> firmowe.
            </div>
        </div>
        <div class="col-lg-6 text-end">
            <a type="button" href="{{ route('login') }}" class="btn btn-primary text-white text-uppercase me-1">
                Zaloguj się
            </a>
            <a  href="{{ route('register') }}" class="btn btn-outline-primary text-uppercase">
                Zarejestruj konto
            </a>
        </div>
    </div>
</div>
