<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            @if ($data->status !== 3 && $data->status !== 4)
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('workplan.edit', $data->id) }}">
                    <i class='bx bx-cog me-2'></i>
                    <span>Progress</span>
                </a>
            </li>
            @endif
            @can('edit-realisasi-kerja')
                @if(auth()->user()->id == $data->sales_id || auth()->user()->hasRole('Super Admin'))
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('workplan.edit.data', $data->id) }}">
                        <i class='bx bxs-edit me-2'></i>
                        <span>Edit</span>
                    </a>
                </li>
                @endif
            @endcan
            @can('read-realisasi-kerja')
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('workplan.show', $data->id) }}">
                    <i class='bx bx-show-alt me-2'></i>
                    <span>Lihat Detail</span>
                </a>
            </li>
            @endcan
            @can('delete-realisasi-kerja')
                @if(auth()->user()->id == $data->sales_id || auth()->user()->hasRole('Super Admin'))
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('workplan.destroy', $data->id) }}" id="workplanDelete-{{ $data->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="dropdown-item d-flex align-items-center"
                            type="button"
                            onclick="confirmDelete( 'data ini', 'workplan', 'workplanDelete-{{$data->id}}' )"
                        >
                            <i class='bx bxs-trash me-2'></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </li>
                @endif
            @endcan
        </ul>
    </div>
</div>