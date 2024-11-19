<div class="d-flex gap-1">
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditRoles-{{ $random }}">Edit</button>
  
    <!-- Modal -->
    <div class="modal fade" id="modalEditRoles-{{ $random }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <form action="{{ route('roles.update', $role->id) }}" id="editRoles-{{ $random }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Perbaharui Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_{{ $random }}" class="form-label">Nama Roles</label>
                            <input type="text" class="form-control" id="name_{{ $random }}" name="name" autocomplete="off" spellcheck="false" value="{{ $role->name }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="confirmEdit('editRoles-{{$random}}')">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
  
    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block" id="deleteRole-{{$random}}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger" onclick="commonDelete('deleteRole-{{$random}}')">Hapus</button>
    </form>
         
    <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">Permission</a>
</div>