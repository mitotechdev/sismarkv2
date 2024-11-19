@canany(['edit-recap-invoice', 'delete-recap-invoice'])
<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            @can('edit-recap-invoice')
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('recap-invoice.edit', $data->id) }}">
                    <i class='bx bx-edit me-2'></i>
                    <span>Edit</span>
                </a>
            </li>
            @endcan
            @can('delete-recap-invoice')
            <li>
                <form action="{{ route('recap-invoice.destroy', $data->id) }}" method="POST" id="formDeleteRecapInvoice-{{ $data->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item" type="button" onclick="commonDelete('formDeleteRecapInvoice-{{ $data->id }}')">
                        <i class='bx bx-trash-alt me-1'></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </li>
            @endcan
        </ul>
    </div>
</div>
@endcanany