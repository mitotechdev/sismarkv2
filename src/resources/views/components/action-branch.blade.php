<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBranch-{{$branch->id}}">
    Edit
</button>

<div class="modal fade" id="editBranch-{{$branch->id}}" tabindex="-1" aria-hidden="true">
    <form action="{{ route('branches.update', $branch->id) }}" class="needs-validation" id="formEditBranch-{{$branch->id}}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Data Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="codeBranch" class="form-label">Kode Branch</label>
                        <input type="text" class="form-control" id="codeBranch" name="code" autocomplete="off" spellcheck="false" value="{{ $branch->code }}" required>
                        <small class="form-text">Kode branch harus unik dari data master branch</small>
                    </div>
                    <div class="mb-3">
                        <label for="nameBranch" class="form-label">Nama Branch</label>
                        <input type="text" class="form-control" id="nameBranch" name="name" autocomplete="off" spellcheck="false" value="{{ $branch->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" autocomplete="off" spellcheck="false" value="{{ $branch->npwp }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" spellcheck="false" value="{{ $branch->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Branch</label>
                        <input type="text" class="form-control" id="address" name="address" autocomplete="off" spellcheck="false" value="{{ $branch->address }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="pic" class="form-label">PIC Branch</label>
                        <input type="text" class="form-control" id="pic" name="pic" autocomplete="off" spellcheck="false" value="{{ $branch->pic }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="confirmEdit('formEditBranch-{{$branch->id}}')">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="d-inline-block" id="deleteBranch-{{$branch->id}}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $branch->code}}', 'master branch', 'deleteBranch-{{$branch->id}}' )">Hapus</button>
</form>