@canany(['edit-tax', 'delete-tax'])
    <div class="d-flex gap-1">
        @can('edit-tax')
        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTax-{{ $tax->id }}">Edit</button>
    
        <!-- Modal -->
        <div class="modal fade" id="modalEditTax-{{ $tax->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <form action="{{ route('tax.update', $tax->id) }}" id="editTax-{{$tax->id}}" method="POST" novalidate>
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
                                <label for="name" class="form-label">Nama Pajak</label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" spellcheck="false" value="{{ $tax->name }}" placeholder="PPN 11%" required>
                            </div>
                            <div class="mb-3">
                                <label for="tax" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="tax" name="tax" autocomplete="off" spellcheck="false" step="any" value="{{ $tax->tax }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="confirmEdit('editTax-{{$tax->id}}')">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endcan
    
        @can('delete-tax')
        <form action="{{ route('tax.destroy', $tax->id) }}" method="POST" class="d-inline-block" id="deleteTax-{{$tax->id}}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $tax->name}}', 'databases', 'deleteTax-{{$tax->id}}' )">Hapus</button>
        </form>
        @endcan
    </div>
@endcanany