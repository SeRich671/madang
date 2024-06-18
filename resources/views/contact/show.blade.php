@extends('layouts.app')

@section('content')
    @if(Auth::check() && !auth()->user()->branch_id)
        @include('parts.branch-required')
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
{{--                <div class="mb-4 bg-white p-4">--}}
{{--                    {{ Breadcrumbs::render('product.show', $department, $category, $product) }}--}}
{{--                </div>--}}
                <div class="p-4 bg-white">
                    <div class="text-primary">
                        <h4>Formularz kontaktowy</h4>
                        <hr>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store', current_subdomain()) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-lg-4 col-form-label text-lg-end">Twój email</label>
                            <div class="col-lg-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-lg-4 col-form-label text-lg-end">Temat</label>
                            <div class="col-lg-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="content" class="col-lg-4 col-form-label text-lg-end">Wiadomość</label>
                            <div class="col-lg-6">
                                <textarea rows="10" class="form-control @error('content') is-invalid @enderror" name="content" id="content" required autocomplete="content">{{ old('content') }}</textarea>
                                {{--                            <input id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ old('content') }}" required autocomplete="content" autofocus>--}}

                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="attachment" class="col-lg-4 col-form-label text-lg-end">Załącznik</label>
                            <div class="col-lg-6">
                                <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" autocomplete="attachment">
                                @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="g-recaptcha justify-content-center d-flex" data-sitekey="{{ config('recaptcha.site-key') }}"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-4 text-center">
                                <button type="submit" class="btn btn-primary text-white">
                                    Wyślij
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
