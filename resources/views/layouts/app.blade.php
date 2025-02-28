<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-body-secondary">
    <div id="app">
        @include('parts.fixed-nav')
        @include('parts.second-nav')

        <div class="py-4">
            <div class="container bg-white text-danger p-4 text-center">
                <span style="font-size:24px">
                    Witamy w Naszym nowym serwisie internetowym.<br>
                    Informujemy, że w celu składania zamówień należy się na nowo zarejestrować.
                </span>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
        @include('parts.footer')
    </div>
    <div class="modal fade" id="productImageModal" tabindex="-1" aria-labelledby="productImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Product Image">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productExportUser" tabindex="-1" aria-labelledby="productExportUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Zestawienie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" id="exportForm" action="{{ route('product.export') }}">
                        <div class="row">
                            <div id="hiddenInputsContainer"></div>
                            <div class="col-lg-12">
                                <label for="has_image">Wyświetlić obrazek?</label>
                                <select id="has_image" name="has_image" class="form-control">
                                    <option value="0">Nie</option>
                                    <option value="1">Tak</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <button type="submit" class="btn btn-primary text-white">
                                    Pobierz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="cookie-banner" class="bg-light py-3 fixed-bottom" style="z-index: 9999; display: none;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9 text-center text-md-start">
                    <p class="mb-0">
                        Strona korzysta z plików cookies w celu realizacji usług i zgodnie z Polityką Plików Cookies. Możesz określić warunki przechowywania lub dostępu do plików cookies w Twojej przeglądarce.
                    </p>
                </div>
                <div class="col-md-3 text-center text-md-end">
                    <button id="accept-cookies" class="btn btn-primary text-white">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the flag is not set, then display the banner
            if (!localStorage.getItem("cookieBannerAccepted")) {
                document.getElementById("cookie-banner").style.display = "block";
            }

            document.getElementById("accept-cookies").addEventListener("click", function() {
                // Set the flag in localStorage so the banner won't be shown again
                localStorage.setItem("cookieBannerAccepted", "true");
                // Hide the banner
                document.getElementById("cookie-banner").style.display = "none";
            });
        });
    </script>

    @stack('scripts')
    <script type="application/javascript">
        function showProductImage(src) {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = src; // Set the source of the modal image to the source of the clicked image
        }
    </script>
    <script type="application/javascript">
        const form = document.getElementById('exportForm');

        form.addEventListener('submit', function (e) {
            // Prevent the default form submission
            e.preventDefault();

            // Container where we'll append our hidden inputs
            const hiddenInputsContainer = document.getElementById('hiddenInputsContainer');

            // Clear previous inputs
            hiddenInputsContainer.innerHTML = '';

            // Find all elements with the class 'exportable'
            const exportableElements = document.querySelectorAll('.exportable');

            // Loop through all elements and create hidden inputs
            exportableElements.forEach((element, index) => {
                const exportId = element.getAttribute('data-export-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]'; // Name your input correctly so it can be easily read on the server side
                input.value = exportId;
                hiddenInputsContainer.appendChild(input);
            });

            // After appending all hidden inputs, submit the form
            form.submit();
        });
    </script>
    <script>
        document.addEventListener('keydown', function(event) {
            // Check if the pressed key is 'Backspace'
            if (event.key === 'Backspace') {
                // Prevent default action to avoid deleting text in inputs or textareas
                if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'TEXTAREA') {
                    event.preventDefault();
                    // Navigate to the previous page
                    window.history.back();
                }
            }
        });

        (function() {
            // Create a unique key for the current page using its pathname.
            // You can customize this key if needed.
            const scrollKey = 'scrollPos_' + window.location.pathname;

            // Save scroll position when an internal link is clicked.
            // This uses event delegation to capture clicks on any <a> that points
            // to the same origin.
            document.addEventListener('click', function(e) {
                const anchor = e.target.closest('a');
                if (anchor && anchor.href && anchor.href.startsWith(window.location.origin)) {
                    // Save the current scroll position in sessionStorage.
                    sessionStorage.setItem(scrollKey, window.pageYOffset);
                }
            });

            // Alternatively, you can also listen to 'beforeunload' if you want to capture all navigations.
            // window.addEventListener('beforeunload', function() {
            //   sessionStorage.setItem(scrollKey, window.pageYOffset);
            // });

            // When the page loads, check if a scroll position was saved and restore it.
            document.addEventListener('DOMContentLoaded', function() {
                const savedPos = sessionStorage.getItem(scrollKey);
                if (savedPos !== null) {
                    // Scroll to the saved position.
                    window.scrollTo(0, parseInt(savedPos, 10));
                    // Optionally, remove the saved value so it doesn't affect future navigations.
                    sessionStorage.removeItem(scrollKey);
                }
            });
        })();

    </script>
</body>
</html>
