<li class="mt-2">
    {{ $category['name'] }}
        <form class="d-inline" method="POST" action="{{ route('admin.category.destroy', $category['id']) }}">
                @method('DELETE')
                @csrf
                <a class="btn btn-sm btn-primary text-white" href="{{ route('admin.category.edit', $category['id']) }}?page={{ request()->get('page') }}">
                        <i class="bi bi-pen"></i>
                </a>
                <a class="ms-1 btn btn-sm btn-primary text-white" href="{{ route('admin.category.create') . '?for=' . $category['id'] }}">
                        <i class="bi bi-plus"></i>
                </a>
                @if(count($category['children']) == 0 && !$category['products_count'])
                        <button type="submit" class="ms-1 btn btn-sm btn-primary text-white">
                                <i class="bi bi-trash"></i>
                        </button>
                @else
                        <button type="submit" class="ms-1 btn btn-sm btn-primary text-white" disabled>
                                <i class="bi bi-trash"></i>
                        </button>
                @endif
        </form>
    @if(count($category['children']) > 0)
        <ul>
            @foreach($category['children'] as $child)
                @include('admin.category.parts.category-tree', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
