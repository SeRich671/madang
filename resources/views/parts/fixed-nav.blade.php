<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        @php
            $headerDepartment = \App\Models\Department::where('subdomain', current_subdomain())->first();
        @endphp
        @if($headerDepartment)

        <a class="navbar-brand" href="{{ config('app.url') }}"><img src="{{ asset('storage/' . $headerDepartment->image) }}" alt="" width="140" height="50" class="d-inline-block align-text-top"></a>
        @else
        <a class="navbar-brand" href="{{ config('app.url') }}"><img src="{{ asset('storage/departments/default.png') }}" alt="" width="140" height="50" class="d-inline-block align-text-top"></a>
        @endif
        <a class="navbar-brand" href="{{ config('app.url') }}">{{ isset($headerDepartment) && !is_string($headerDepartment) ? $headerDepartment->name : 'Madang' }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form method="GET" action="{{ route('search.index', current_subdomain() ?: '') }}" class="d-flex mx-auto">
                <div class="input-group mb-3 align-middle">
                    <input autocomplete="off" type="text" class="form-control" name="global_query" value="{{ request()->get('global_query') }}" id="searchInput" placeholder="Nazwa produktu" aria-label="Search here">
                    <ul class="list-group" id="resultList" style="display: none; margin-top:40px; position: absolute; width: 100%; cursor: pointer; z-index: 1000; max-height:500px; overflow-y: auto">
                    </ul>
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
{{--            <form method="GET" action="{{ route('search.index', current_subdomain() ?: '') }}" class="d-flex mx-auto">--}}
{{--                <input class="form-control me-2" minlength="3" name="global_query" value="{{ request()->get('global_query') }}" type="search" placeholder="Nazwa lub kod produktu" aria-label="Search">--}}
{{--                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>--}}
{{--            </form>--}}
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('cart.show') }}">
                        <i class="bi bi-cart-fill"></i> @if(cart_count()) <span class="badge bg-primary text-white">{{ cart_count() }}</span> @endif
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu px-2" style="min-width: 300px" aria-labelledby="navbarDropdown">
                        @if(Auth::check())
                            @if(auth()->user()->role == \App\Enums\User\RoleEnum::ADMIN)
                                <li><a class="dropdown-item" href="{{ config('app.url') . '/admin' }}">Panel administratora</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edycja danych</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.order.index') }}">Moje zamówienia</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.address.index') }}">Książka adresowa</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.billing.index') }}">Dane do faktury</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Wyloguj się</button>
                                </form>

                            </li>
                        @else
                            <li class="text-center">
                                <i class="bi bi-bag-dash" style="font-size:38px"></i><br>
                                <strong style="font-size:1.2em">Witaj w madang.pl!</strong><br><br>
                                Zaloguj się bądź zarejestruj
                                aby dokonać zamówienia na swoje produkty
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="text-center">
                                <a class="btn btn-primary w-100 text-white" href="{{ route('login') }}">
                                    Zaloguj się
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Zarejestruj konto</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        @php
            $productSearchOptions = \App\Models\Product::where('is_available', 1)
                ->pluck('name');
        @endphp
        document.addEventListener('DOMContentLoaded', function() {
            const options = [
                @foreach($productSearchOptions as $option)
                "{{ $option  }}",
                @endforeach
            ];

            const searchInput = document.getElementById('searchInput');
            const resultList = document.getElementById('resultList');
            let timeout = null;

            // Debounced function to handle search filtering
            function handleSearch() {
                const input = searchInput.value.toLowerCase();

                // Clear previous results
                resultList.innerHTML = '';

                // Filter options based on input
                const filteredOptions = options.filter(option => option.toLowerCase().includes(input));

                // Display results
                if (filteredOptions.length > 0 && input.trim() !== '') {
                    resultList.style.display = 'block';
                    filteredOptions.forEach(option => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.textContent = option;
                        li.addEventListener('click', function() {
                            searchInput.value = this.textContent;
                            resultList.style.display = 'none';
                        });
                        resultList.appendChild(li);
                    });
                } else {
                    resultList.style.display = 'none';
                }
            }

            // Listener for input events on the search input with debouncing
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(handleSearch, 500); // Adjust time as necessary
            });

            // Listener to handle clicks outside the search input and results list
            document.addEventListener('click', function(event) {
                if (!searchInput.contains(event.target) && !resultList.contains(event.target)) {
                    resultList.style.display = 'none';
                }
            });
        });
    </script>
@endpush
