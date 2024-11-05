<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('pricelist.edit', $data->id ) }}">
                    <i class='bx bxs-edit me-2'></i>
                    <span>Edit</span>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="">
                    <i class='bx bx-cog me-2'></i>
                    <span>Hapus</span>
                </a>
            </li>
        </ul>
    </div>
</div>