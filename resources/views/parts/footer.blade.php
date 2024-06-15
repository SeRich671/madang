
    @if(current_subdomain())
        @php
            $footerDepartment = \App\Models\Department::where('subdomain', current_subdomain())->first();
        @endphp

        @if($footerDepartment)
            <footer class="pt-3 bg-white">
                @if(auth()->check())
                    {!! $footerDepartment->footer_auth !!}
                @else
                    {!! $footerDepartment->footer_guest !!}
                @endif
                <div class="bg-dark">
                    <div class="container p-3">
                        <span class="text-white">Korzystanie z naszego serwisu oznacza akceptację </span><span class="text-primary"> regulaminu</span>
                    </div>
                </div>
            </footer>
        @endif
    @else
        <div class="container py-3">
            <div class="row">
                <div class="col-lg-3 mt-2">
                    <div class="text-uppercase font-weight-bold">madang.pl</div>
                    <div><a class="link-primary" href="#">Regulamin</a></div>
                    <div><a class="link-primary" href="#">O nas</a></div>
                    <div><a class="link-primary" href="#">Polityka plików cookies</a></div>
                </div>
                <div class="col-lg-3 mt-2">
                    <div class="text-uppercase font-weight-bold">madang Gdynia</div>
                    <div>ul. Świętego Piotra 2, 81-340 Gdynia</div>
                    <div>tel. (58) 620 05 90</div>
                    <div>kom. 508 27 24 33</div>
                    <div>fax (58) 621 16 20</div>
                </div>
                <div class="col-lg-3 mt-2">
                    <div class="text-uppercase font-weight-bold">madang Kołobrzeg</div>
                    <div>ul. Bałtycka 17-18, 78-100 Kołobrzeg</div>
                    <div>tel. (94) 351 75 14</div>
                    <div>kom. 601 657 078</div>
                </div>
                <div class="col-lg-3 mt-2">
                    <div class="text-uppercase font-weight-bold">madang Dźwinów</div>
                    <div>ul. Juliusza Słowackiego 21, 72-420 Dziwnów</div>
                    <div>tel. (91) 381 35 22</div>
                    <div>kom. 669 630 690</div>
                </div>
            </div>
        </div>
    @endif

