@extends('layouts.admin', ['menuName' => 'Tworzenie kategorii' . ($selectedCategory ? ' dla ' . $selectedCategory->name : '')])

@section('content')
    <form method="POST" action="{{ route('admin.category.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="department_id">Dział</label>
                <input type="hidden" name="department_id" value="{{ $selectedDepartment?->id }}">
                <select id="department_id" name="department_id" class="form-control" @disabled($selectedDepartment) required>
                    <option disabled value="" @selected(!$selectedDepartment)>Wybierz dział</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected($department->id == $selectedDepartment?->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="category_id">Rodzic</label>
                <input type="hidden" name="category_id" value="{{ $selectedCategory?->id }}">
                <select id="category_id" name="category_id" class="form-control" @disabled($selectedCategory)>
                    <option disabled value="" @selected(!$selectedCategory)>Wybierz rodzica</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($category->id == $selectedCategory?->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 offset-lg-3">
                <label for="name">Nazwa</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="col-lg-12 mt-4 text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                    Powrót
                </a>
                <button class="btn btn-primary text-white">
                    Zapisz
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#department_id').select2();
            $('#category_id').select2();
        });
    </script>
@endpush
