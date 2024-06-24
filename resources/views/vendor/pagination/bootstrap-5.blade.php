@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="me-2">
            <select class="form-control" name="filters[per_page]" id="perPageSelector" onchange="changePerPage()">
                <option value="12" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '12') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '12'))>12</option>
                <option value="24" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '24') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '24'))>24</option>
                <option value="36" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '36') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '36'))>36</option>
                <option value="48" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '48') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '48'))>48</option>
                <option value="60" @selected((!isset(request()->get('filters')['per_page']) && cache()->get('settings.per_page') == '60') || (isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '60'))>60</option>
                <option value="100000" @selected(isset(request()->get('filters')['per_page']) && request()->get('filters')['per_page'] == '100000')>Wszystkie</option>
            </select>
        </div>
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! __('Showing') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif

@push('scripts')
    <script type="application/javascript">
        function changePerPage() {
            var url = new URL(window.location.href);
            var perPage = document.getElementById('perPageSelector').value;
            url.searchParams.set('filters[per_page]', perPage);
            window.location.href = url.href;
        }
    </script>
@endpush
