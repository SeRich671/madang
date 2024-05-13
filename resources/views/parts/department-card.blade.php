<div class="card mb-2 rounded-0">
    <img src="{{ asset('storage/' . $department->image) }}" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title">{{ $department->name }}</h5>
        <a href="{{ route('department.index', $department->subdomain) }}" class="btn btn-primary text-white rounded-0">Przejdź</a>
    </div>
</div>
