<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="{{ empty(request()->get('filters')) }}" aria-controls="collapseOne">
                Sortowanie i filtry
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <form method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="global_query" value="{{ request()->get('global_query') }}">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="filters[sort_type]">Rodzaj sortowania</label>
                            <select class="form-control" name="filters[sort_type]" id="filters[sort_type]">
                                <option value="name" @selected(isset(request()->get('filters')['sort_type']) && request()->get('filters')['sort_type'] == 'name')>Po nazwie</option>
                                <option value="price" @selected(isset(request()->get('filters')['sort_type']) && request()->get('filters')['sort_type'] == 'price')>Po cenie</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="filters[sort_order]">Kierunek sortowania</label>
                            <select class="form-control" name="filters[sort_order]" id="filters[sort_order]">
                                <option value="asc" @selected(isset(request()->get('filters')['sort_order']) && request()->get('filters')['sort_order'] == 'asc')>Rosnąco</option>
                                <option value="desc" @selected(isset(request()->get('filters')['sort_order']) && request()->get('filters')['sort_order'] == 'desc')>Malejąco</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="filters[per_page]">Produktów na stronie</label>
                            <select class="form-control" name="filters[per_page]" id="filters[per_page]">
                                <option value="12" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '12') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '12'))>12</option>
                                <option value="24" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '24') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '24'))>24</option>
                                <option value="36" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '36') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '36'))>36</option>
                                <option value="48" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '48') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '48'))>48</option>
                                <option value="60" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '60') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '60'))>60</option>
                                <option value="all" @selected(isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == 'all')>Wszystkie</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <label for="filters[price][from]">Cena</label><br>
                            <div class="input-group">
                                <input name="filters[price][from]" type="number" class="form-control" placeholder="Od" value="{{ request()->input('filters.price.from') }}">
                                <input name="filters[price][to]" type="number" class="form-control" placeholder="Do" value="{{ request()->input('filters.price.to') }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="price_from">Opakowanie</label><br>
                            <div class="input-group">
                                <input name="filters[count_in_package][from]" type="number" class="form-control" placeholder="Od" value="{{ request()->input('filters.count_in_package.from') }}">
                                <input name="filters[count_in_package][to]" type="number" class="form-control" placeholder="Do" value="{{ request()->input('filters.count_in_package.to') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 text-center justify-content-center">
                            <label for="filters[show_unavailable]">Pokaż niedostępne</label><br>
                            <input type="hidden" name="filters[show_unavailable]" value="0">
                            <input id="filters[show_unavailable]" name="filters[show_unavailable]" class="form-check d-inline" type="checkbox" @checked(request()->input('filters.show_unavailable'))>
                        </div>
                        <div class="col-lg-2 text-center justify-content-center">
                            <label for="filters[sticker]">Miejsce na naklejkę</label><br>
                            <input type="hidden" name="filters[sticker]" value="0">
                            <input id="filters[sticker]" name="filters[sticker]" class="form-check d-inline" type="checkbox" value="1" @checked(request()->input('filters.sticker'))>
                        </div>

                        @foreach($dynamicAttributes as $key => $dynamicAttribute)
                            <div class="col-lg-4">
                                <label for="filters[dynamic_attribute][{{$key}}][]">{{ $dynamicAttribute->first()->attribute_name }}</label>
                                <select class="form-control dynamic_attribute" name="filters[dynamic_attribute][{{$key}}][]" id="ffilters[dynamic_attribute][{{$key}}][]" multiple>
                                    @foreach($dynamicAttribute as $value)
                                        <option value="{{ $value->value }}" @selected(isset(request()->get('filters')['dynamic_attribute'][$key]) && in_array($value->value, request()->get('filters')['dynamic_attribute'][$key]))>{{ $value->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div class="col-lg-12 mt-2 text-center">
                            <button type="submit" class="btn btn-primary text-white">Wyszukaj</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('.dynamic_attribute').select2();
        });
    </script>
@endpush
