@if ($salesOrder->approval_id == 1)
<div class="d-flex gap-1">
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSalesOrderItem-{{$uniqueNumber}}">
        Edit
    </button>

    <div class="modal fade" id="editSalesOrderItem-{{$uniqueNumber}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <form action="{{ route('sales.order.item.update', $data->id) }}" class="needs-validation" method="POST" novalidate id="edit-item-so-{{$uniqueNumber}}">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Perbaharui Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name_product_{{$uniqueNumber}}" class="col-md-3 col-form-label">Product</label>
                            <div class="col-md-9">
                                <select class="form-select select-box" name="product_id" id="name_product_{{$uniqueNumber}}" title="Nama produk" required>
                                    <option value="" selected>Pilih produk...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $data->product_id ? "selected" : ""}}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="qty_{{$uniqueNumber}}" class="col-sm-3 col-form-label">QTY</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="qty" id="qty_{{$uniqueNumber}}" oninput="itemValueChange('{{$uniqueNumber}}')" title="QTY Item" placeholder="QTY" value="{{ $data->qty }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="price_{{$uniqueNumber}}" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" step=".01" placeholder="0.00" name="price" id="price_{{$uniqueNumber}}" oninput="itemValueChange('{{$uniqueNumber}}')" title="Harga satuan item" value="{{ $data->price }}" required>
                                </div>
                                <small>Masukan harga DPP produk, untuk kalkulasi pajak di akhir.</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="discount_{{$uniqueNumber}}" class="col-sm-3 col-form-label">Discount Product</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" step=".01" placeholder="0.00" name="discount" id="discount_{{$uniqueNumber}}" oninput="itemValueChange('{{$uniqueNumber}}')" title="Diskon item" value="{{ $data->discount }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Grand Total</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <input type="text" id="show_grand_total_{{$uniqueNumber}}" class="form-control fw-bold" value="{{ 'Rp '. number_format($data->total_amount, 2, ',', '.') }}" autocomplete="off" spellcheck="false" readonly disabled>
                                    <input type="hidden" value="" name="total_amount" id="total_amount_{{$uniqueNumber}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="confirmEdit('edit-item-so-{{$uniqueNumber}}')">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <form action="{{ route('sales.order.item.destroy', $data->id) }}" method="POST" class="needs-validation" novalidate id="delete-item-so-{{$uniqueNumber}}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteItemSalesOrders('delete-item-so-{{$uniqueNumber}}')">Hapus</button>
    </form>
</div>
@endif