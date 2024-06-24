@extends('layouts.admin', ['menuName' => 'Działy'])

@section('content')
    {{ $errors->any() }}
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Obraz</th>
                    <th>Subdomena</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments->items() as $department)
                    <tr>
                        <td>
                            {{ $department->name }}
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $department->image) }}" style="max-width:300px" alt="Image">
                        </td>
                        <td>{{ $department->subdomain }}</td>
                        <td>{{ \App\Enums\Department\StatusEnum::getDescription($department->status) }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.department.destroy', $department) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-primary text-white" href="{{ route('admin.department.edit', $department) }}"><i class="bi bi-pen"></i></a>
                                <button type="submit" class="ms-1 btn btn-danger text-white" @disabled($department->categories()->count())>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            {{ $departments->links() }}
        </div>
        <div class="col-lg-12 text-end">
            <a href="{{ route('admin.department.create') }}" class="btn btn-primary text-white">Dodaj nowy</a>
        </div>
    </div>
@endsection
