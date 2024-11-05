<div class="d-flex gap-1">
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTypeCustomer-{{ $random }}">Edit</button>
  
    <!-- Modal -->
  <div class="modal fade" id="modalEditTypeCustomer-{{ $random }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <form action="{{ route('type-customer.update', $typeCustomer->id) }}" id="editTypeCustomer-{{ $random }}" method="POST" novalidate>
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
                            <label for="name_{{ $random }}" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="name_{{ $random }}" name="name" autocomplete="off" spellcheck="false" value="{{ $typeCustomer->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipe_{{ $random }}" class="form-label">Tipe</label>
                            <input type="text" class="form-control" id="tipe_{{ $random }}" name="tag_front_end" autocomplete="off" spellcheck="false" value="{{ $typeCustomer->tag_front_end }}" required>
                            <div class="form-text">Ex: primary, warning, danger, etc</div>
                        </div>
                        <div class="mb-3">
                            <label for="status_{{ $random }}" class="form-label">Tag Status</label>
                            <input type="text" class="form-control" id="status_{{ $random }}" name="tag_status" autocomplete="off" spellcheck="false" value="{{ $typeCustomer->tag_status }}" required>
                        </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-primary" onclick="confirmEdit('editTypeCustomer-{{$random}}')">Simpan Perubahan</button>
                  </div>
              </div>
          </div>
      </form>
  </div>
  
  <form action="{{ route('type-customer.destroy', $typeCustomer->id) }}" method="POST" class="d-inline-block" id="deleteTypeCustomer-{{$random}}">
      @csrf
      @method('DELETE')
      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $typeCustomer->name}}', 'databases', 'deleteTypeCustomer-{{$random}}' )">Hapus</button>
  </form>
</div>