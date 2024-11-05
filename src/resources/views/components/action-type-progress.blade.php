<div class="d-flex gap-1">
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTypeProgress-{{ $random }}">Edit</button>
  
    <!-- Modal -->
    <div class="modal fade" id="modalEditTypeProgress-{{ $random }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <form action="{{ route('type-progress.update', $data->id) }}" id="editTypeProgress-{{ $random }}" method="POST" novalidate>
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
                            <label for="name_{{$random}}" class="form-label">Nama Progress</label>
                            <input type="text" class="form-control" id="name_{{$random}}" name="name" autocomplete="off" title="Nama Progress" spellcheck="false" value="{{ $data->name }}" placeholder="Mapping" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_{{$random}}" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status_{{$random}}" name="status" autocomplete="off" title="Status" spellcheck="false" value="{{ $data->status }}" placeholder="Prospect" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="confirmEdit('editTypeProgress-{{ $random }}')">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
  
  <form action="{{ route('type-progress.destroy', $data->id) }}" method="POST" class="d-inline-block" id="deleteTax-{{$random}}">
      @csrf
      @method('DELETE')
      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $data->name}}', 'databases', 'deleteTax-{{$random}}' )">Hapus</button>
  </form>
</div>