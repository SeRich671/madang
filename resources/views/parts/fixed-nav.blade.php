<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Brand and Toggler -->
        <a class="navbar-brand" href="{{ config('app.url') }}">
            @php
                $headerDepartment = \App\Models\Department::where('subdomain', current_subdomain())->first();
            @endphp
            @if($headerDepartment)
                <img src="{{ asset('storage/' . $headerDepartment->image) }}" alt="" width="140" height="50" class="d-inline-block align-text-top">
            @else
                <img src="{{ asset('storage/departments/default.png') }}" alt="" width="140" height="50" class="d-inline-block align-text-top">
            @endif
        </a>
        <a class="navbar-brand" href="{{ config('app.url') }}">
            {{ isset($headerDepartment) && !is_string($headerDepartment) ? $headerDepartment->name : 'Madang' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop Search: Visible only on large screens -->
        <div class="collapse navbar-collapse text-right" id="navbarSupportedContent">
            <form method="GET" action="{{ route('search.index', current_subdomain() ?: '') }}"
                  class="d-none d-lg-block ms-auto">
                <div class="input-group">
                    <input id="searchInputDesktop" autocomplete="off" type="text" class="form-control" name="global_query"
                           value="{{ request()->get('global_query') }}" placeholder="Nazwa produktu" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Other navigation items -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.show') }}">
                        <i class="bi bi-cart-fill"></i>
                        @if(cart_count())
                            <span class="badge bg-primary text-white">{{ cart_count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu px-2" style="min-width: 300px; left:-250px;" aria-labelledby="navbarDropdown">
                        @if(Auth::check())
                            @if(auth()->user()->role == \App\Enums\User\RoleEnum::ADMIN)
                                <li>
                                    <a class="dropdown-item" href="{{ config('app.url') . '/admin' }}">Panel administratora</a>
                                </li>
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
                                Zaloguj się bądź zarejestruj, aby dokonać zamówienia na swoje produkty
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="text-center">
                                <a class="btn btn-primary w-100 text-white" href="{{ route('login') }}">
                                    Zaloguj się
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}">Zarejestruj konto</a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div><!-- /.collapse -->

        <!-- Mobile Search: Visible only on small screens -->
        <!-- Mobile Search: Visible only on small screens -->
        <div class="d-lg-none mt-2 w-100">
            <form method="GET" action="{{ route('search.index', current_subdomain() ?: '') }}">
                <div class="input-group">
                    <input id="searchInputMobile" autocomplete="off" type="text" class="form-control" name="global_query"
                           value="{{ request()->get('global_query') }}" placeholder="Nazwa produktu" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

    </div><!-- /.container -->
</nav>

@push('scripts')
    <script>
        // These functions mimic the PHP logic for normalizing and trimming.
        function normalizePolish(str) {
            const mapping = {
                'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z', 'ż': 'z',
                'Ą': 'a', 'Ć': 'c', 'Ę': 'e', 'Ł': 'l', 'Ń': 'n', 'Ó': 'o', 'Ś': 's', 'Ź': 'z', 'Ż': 'z'
            };
            return str.replace(/[ąćęłńóśźżĄĆĘŁŃÓŚŹŻ]/g, match => mapping[match]);
        }

        function normalizeString(str) {
            return normalizePolish(str).toLowerCase();
        }

        function trimEndings(word) {
            const vowels = ['a','e','i','o','u','y'];
            while (word.length > 4 && vowels.includes(word.slice(-1))) {
                word = word.slice(0, -1);
            }
            return word;
        }

        @php
            $departmentSB = \App\Models\Department::where('subdomain', current_subdomain())->first();
            $productSearchOptions = \App\Models\Product::when($departmentSB, function ($query) use ($departmentSB) {
                    return $query->whereHas('categories', function ($query2) use ($departmentSB) {
                        return $query2->where('department_id', $departmentSB->id);
                    });
                })
                ->where('is_available', 1)
                ->where('in_stock', '>', 0)
                ->pluck('name');
        @endphp

        document.addEventListener('DOMContentLoaded', function() {
            const options = [
                @foreach($productSearchOptions as $option)
                    "{{ $option }}",
                @endforeach
            ];

            // --- Desktop auto-suggest ---
            const searchInputDesktop = document.getElementById('searchInputDesktop');
            if (searchInputDesktop) {
                const resultListDesktop = document.createElement('ul');
                resultListDesktop.className = 'list-group';
                resultListDesktop.style.cssText = 'display:none; top:40px; position:absolute; width:100%; cursor:pointer; z-index:1000; max-height:500px; overflow-y:auto;';
                searchInputDesktop.parentNode.style.position = 'relative';
                searchInputDesktop.parentNode.appendChild(resultListDesktop);

                let timeoutDesktop = null;
                searchInputDesktop.addEventListener('input', function() {
                    clearTimeout(timeoutDesktop);
                    timeoutDesktop = setTimeout(function() {
                        // Normalize and trim the input value
                        let input = searchInputDesktop.value;
                        input = normalizeString(input);
                        input = trimEndings(input);

                        resultListDesktop.innerHTML = '';
                        const filteredOptions = options.filter(option => {
                            let normalizedOption = normalizeString(option);
                            normalizedOption = trimEndings(normalizedOption);
                            return normalizedOption.includes(input);
                        });

                        if (filteredOptions.length > 0 && input.trim() !== '') {
                            resultListDesktop.style.display = 'block';
                            filteredOptions.forEach(option => {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item');
                                li.textContent = option;
                                li.addEventListener('click', function() {
                                    searchInputDesktop.value = this.textContent;
                                    resultListDesktop.style.display = 'none';
                                    searchInputDesktop.form.submit();
                                });
                                resultListDesktop.appendChild(li);
                            });
                        } else {
                            resultListDesktop.style.display = 'none';
                        }
                    }, 500);
                });

                document.addEventListener('click', function(event) {
                    if (!searchInputDesktop.contains(event.target) && !resultListDesktop.contains(event.target)) {
                        resultListDesktop.style.display = 'none';
                    }
                });
            }

            // --- Mobile auto-suggest ---
            const searchInputMobile = document.getElementById('searchInputMobile');
            if (searchInputMobile) {
                const resultListMobile = document.createElement('ul');
                resultListMobile.className = 'list-group';
                resultListMobile.style.cssText = 'display:none; top:40px; position:absolute; width:100%; cursor:pointer; z-index:1000; max-height:500px; overflow-y:auto;';
                searchInputMobile.parentNode.style.position = 'relative';
                searchInputMobile.parentNode.appendChild(resultListMobile);

                let timeoutMobile = null;
                searchInputMobile.addEventListener('input', function() {
                    clearTimeout(timeoutMobile);
                    timeoutMobile = setTimeout(function() {
                        let input = searchInputMobile.value;
                        input = normalizeString(input);
                        input = trimEndings(input);

                        resultListMobile.innerHTML = '';
                        const filteredOptions = options.filter(option => {
                            let normalizedOption = normalizeString(option);
                            normalizedOption = trimEndings(normalizedOption);
                            return normalizedOption.includes(input);
                        });

                        if (filteredOptions.length > 0 && input.trim() !== '') {
                            resultListMobile.style.display = 'block';
                            filteredOptions.forEach(option => {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item');
                                li.textContent = option;
                                li.addEventListener('click', function() {
                                    searchInputMobile.value = this.textContent;
                                    resultListMobile.style.display = 'none';
                                    searchInputMobile.form.submit();
                                });
                                resultListMobile.appendChild(li);
                            });
                        } else {
                            resultListMobile.style.display = 'none';
                        }
                    }, 500);
                });

                document.addEventListener('click', function(event) {
                    if (!searchInputMobile.contains(event.target) && !resultListMobile.contains(event.target)) {
                        resultListMobile.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endpush
