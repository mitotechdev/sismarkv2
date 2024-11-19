@canany(['edit-product', 'delete-product'])
<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            @can('edit-product')
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('product.edit', $data->id) }}">
                    <i class='bx bxs-edit me-2'></i>
                    <span>Edit</span>
                </a>
            </li>
            @endcan
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('product.show', $data->id) }}">
                    <i class='bx bx-show-alt me-2'></i>
                    <span>Lihat Detail</span>
                </a>
            </li>
            @can('delete-product')
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('product.destroy', $data->id) }}" id="productDelete-{{ $data->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        class="dropdown-item d-flex align-items-center"
                        type="button"
                        onclick="confirmDelete('{{ $data->code }}', 'databases', 'productDelete-{{$data->id}}')"
                    >
                        <i class='bx bxs-trash me-2'></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </li>
            @endcan
        </ul>
    </div>
</div>
@endcanany