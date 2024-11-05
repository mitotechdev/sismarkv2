<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editApproval-{{ $approval->id }}">Edit</button>
  
  <!-- Modal -->
<div class="modal fade" id="editApproval-{{ $approval->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <form action="{{ route('approval.update', $approval->id) }}" id="editBranch-{{$approval->id}}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Informasi Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Level Approval</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" spellcheck="false" value="{{ $approval->name }}" placeholder="Draf" required>
                    </div>
                    <div class="mb-3">
                        <label for="tag_front_end" class="form-label">Kategori Approval</label>
                        <input type="text" class="form-control" id="tag_front_end" name="tag_front_end" autocomplete="off" spellcheck="false" value="{{ $approval->tag_front_end }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tag_status" class="form-label">Tag Validasi</label>
                        <input type="text" class="form-control" id="tag_status" name="tag_status" autocomplete="off" spellcheck="false" value="{{ $approval->tag_status }}" placeholder="draf" required>
                        <div class="form-text">Digunakan untuk keperluan validasi</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="confirmEdit('editBranch-{{$approval->id}}')">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<form action="{{ route('approval.destroy', $approval->id) }}" method="POST" class="d-inline-block" id="deleteApproval-{{$approval->id}}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $approval->name}}', 'databases', 'deleteApproval-{{$approval->id}}' )">Hapus</button>
</form>