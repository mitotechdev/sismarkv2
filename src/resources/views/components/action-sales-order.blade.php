<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            @if ($data->approval_id == 2)
                @can('approve-purchase-order')
                <li class="mb-2 px-2">
                    <form action="{{ route('sales.order.approve', $data->id) }}" method="POST" id="approve-item-{{$data->id}}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary w-100" type="button" onclick="confirmApprove('approve-item-{{$data->id}}')">
                            <span>Approved</span>
                        </button>
                    </form>
                </li>
                @endcan
            @elseif ($data->approval_id == 1)
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('sales.order.item', $data->id) }}">
                        <i class='bx bx-data me-2'></i>
                        <span>Kelola Item</span>
                    </a>
                </li>
                @can('edit-purchase-order')
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('sales-order.edit', $data->id) }}">
                        <i class='bx bxs-edit me-2'></i>
                        <span>Edit</span>
                    </a>
                </li>
                @endcan

                @can('delete-purchase-order')
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('sales-order.destroy', $data->id) }}" method="POST" id="deleteSalesOrder-{{ $data->id }}">
                        @csrf
                        @method('DELETE')
                        <button
                            class="dropdown-item d-flex align-items-center"
                            type="button"
                            onclick="commonDelete('deleteSalesOrder-{{ $data->id }}')"
                        >
                            <i class='bx bxs-trash me-2'></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </li>
                @endcan
            @endif
            @if ($data->approval_id != 1)
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('sales-order.show', $data->id) }}">
                    <i class='bx bx-show-alt me-2'></i>
                    <span>Lihat Detail</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>