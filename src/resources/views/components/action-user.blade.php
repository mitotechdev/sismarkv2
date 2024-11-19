<div class="d-flex gap-1">
    <div class="dropdown">
        <button class="btn btn-transparent rounded-circle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-vertical-rounded'></i>
        </button>
      
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('user.edit', $user->id) }}">
                    <i class='bx bx-edit me-2'></i>
                    <span>Edit</span>
                </a>
            </li>
            <li>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" id="userDelete-{{ $user->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item" type="button" onclick="commonDelete('userDelete-{{ $user->id }}')">
                        <i class='bx bx-trash-alt me-1'></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </li>
            
        </ul>
    </div>
</div>