<div class="card h-100 rounded-0">
    <img src="{{ asset('storage/' . $department->image) }}" style="max-height: 100px" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title">{{ $department->name }}</h5>
        <a href="{{ route('department.index', $department->subdomain) }}" class="btn btn-primary text-white rounded-0">Przejdź</a>
    </div>
</div>
