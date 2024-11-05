<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('customer.edit', $data->id) }}">
                    <i class='bx bxs-edit me-2'></i>
                    <span>Edit</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="">
                    <i class='bx bx-archive me-2'></i>
                    <span>Purchase Orders</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('customer.show', $data->id) }}">
                    <i class='bx bx-show-alt me-2'></i>
                    <span>Lihat Detail</span>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="" id="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        class="dropdown-item d-flex align-items-center"
                        type="button"
                    >
                        <i class='bx bxs-trash me-2'></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>