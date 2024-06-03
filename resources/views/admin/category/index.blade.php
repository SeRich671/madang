@extends('layouts.admin', ['menuName' => 'Kategorie produktów'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="accordion" id="accordionExample">
                @foreach($categoryItems as $departmentId => $categoryItem)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $departmentId }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $departmentId }}" aria-expanded="true" aria-controls="collapse{{ $departmentId }}">
                                {{ $departments->where('id', $departmentId)->first()->name }}
                            </button>
                        </h2>
                        <div id="collapse{{ $departmentId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $departmentId }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach($categoryItem as $category)
                                    @include('admin.category.parts.category-tree', ['category' => $category])
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-12 mt-4 text-end">
            <a class="btn btn-primary text-white" href="{{ route('admin.category.create') }}">Dodaj kategorię</a>
        </div>
    </div>
@endsection
