@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales-order.index') }}">Purchase Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Entry Data</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

      <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-4">
                    <small class="text-muted">Tanggal Order</small>
                    <div>{{ $salesOrder->order_date->format('d/m/Y')}}</div>
                </div>
                <div class="col-sm-4">
                    <small class="text-muted">Nama Konsumen</small>
                    <div>{{ $salesOrder->customer->name}}</div>
                </div>
                <div class="col-sm-4">
                    <small class="text-muted">PO Konsumen</small>
                    <div>{{ $salesOrder->no_sales_order}}</div>
                </div>
            </div>
        </div>
      </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createSalesOrderItems">
                <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                <span>Tambah Data</span>
            </button>

            <div class="modal fade" id="createSalesOrderItems" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <form action="{{ route('sales.order.store.item') }}" class="needs-validation form-create" method="POST" novalidate>
                    @csrf
                    @method('POST')
                    <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Data Baru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <label for="name_product" class="col-md-3 col-form-label">Product</label>
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <select class="form-select select-box" name="product_id" id="name_product" title="Nama produk" required>
                                                    <option value="" selected>Pilih produk...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" title="Kemasan" id="packaging" readonly disabled title="Kemasan" placeholder="Kemasan">
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" title="Satuan" id="unit" readonly disabled title="Satuan" placeholder="Satuan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="qty" class="col-sm-3 col-form-label">QTY</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="qty" id="qty" title="QTY Item" oninput="calculateOnInput()" placeholder="QTY" value="{{ old('qty') }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="price" class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" step=".01" placeholder="0.00" oninput="calculateOnInput()" name="price" id="price" title="Harga satuan item" value="{{ old('price') }}" required>
                                        </div>
                                        <small>Masukan harga DPP produk, untuk kalkulasi pajak di akhir.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="discount" class="col-sm-3 col-form-label">Discount Product</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" step=".01" placeholder="0.00" name="discount" oninput="calculateOnInput()" id="discount" title="Diskon item" value="{{ old('discount') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label fw-bold">Grand Total</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" id="show_grand_total" class="form-control fw-bold" autocomplete="off" spellcheck="false" readonly>
                                            <input type="hidden" value="" name="total_amount" id="total_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if ($openRequest)
                <form action="{{ route('sales.order.item.submit', $salesOrder->id) }}" method="POST" id="open-request">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="submitItemSalesOrder('open-request')">Open Request</button>
                </form>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th class="text-nowrap">Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesOrderItems as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->product->unit }}</td>
                                <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editSalesOrderItem-{{$item->id}}">
                                            Edit
                                        </button>
                                    
                                        <div class="modal fade" id="editSalesOrderItem-{{$item->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                                            <form action="{{ route('sales.order.item.update', $item->id) }}" class="needs-validation" method="POST" novalidate id="edit-item-so-{{$item->id}}">
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
                                                                <label for="name_product_{{$item->id}}" class="col-md-3 col-form-label">Product</label>
                                                                <div class="col-md-9">
                                                                    <select class="form-select select-box" name="product_id" id="name_product_{{$item->id}}" title="Nama produk" required>
                                                                        <option value="" selected>Pilih produk...</option>
                                                                        @foreach ($products as $product)
                                                                            <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? "selected" : ""}}>{{ $product->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="qty_{{$item->id}}" class="col-sm-3 col-form-label">QTY</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control" name="qty" id="qty_{{$item->id}}" oninput="itemValueChange('{{$item->id}}')" title="QTY Item" placeholder="QTY" value="{{ $item->qty }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="price_{{$item->id}}" class="col-sm-3 col-form-label">Price</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Rp</span>
                                                                        <input type="number" class="form-control" step=".01" placeholder="0.00" name="price" id="price_{{$item->id}}" oninput="itemValueChange('{{$item->id}}')" title="Harga satuan item" value="{{ $item->price }}" required>
                                                                    </div>
                                                                    <small>Masukan harga DPP produk, untuk kalkulasi pajak di akhir.</small>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="discount_{{$item->id}}" class="col-sm-3 col-form-label">Discount Product</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text">Rp</span>
                                                                        <input type="number" class="form-control" step=".01" placeholder="0.00" name="discount" id="discount_{{$item->id}}" oninput="itemValueChange('{{$item->id}}')" title="Diskon item" value="{{ $item->discount }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-3 col-form-label fw-bold">Grand Total</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" id="show_grand_total_{{$item->id}}" class="form-control fw-bold" value="{{ 'Rp '. number_format($item->total_amount, 2, ',', '.') }}" autocomplete="off" spellcheck="false" readonly disabled>
                                                                        <input type="hidden" value="" name="total_amount" id="total_amount_{{$item->id}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="button" class="btn btn-primary" onclick="confirmEdit('edit-item-so-{{$item->id}}')">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    
                                        <form action="{{ route('sales.order.item.destroy', $item->id) }}" method="POST" class="needs-validation" novalidate id="delete-item-so-{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDeleteItemSalesOrders('delete-item-so-{{$item->id}}')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const config = {
                    search: true,
                    creatable: false,
                    clearable: true,
                    size: '',
                }
        let selectBox = document.querySelectorAll('.select-box');
        selectBox.forEach(element => {
            if (element && element.tagName === 'SELECT') {
                dselect(element, config);
            } 
        });
        $(document).ready(function() {
            $('#datatable_sismark').DataTable();
        })

        let nameProduct = document.getElementById('name_product');
        function updateFieldProductInfo(packaging, unit, data) {
            packaging.value = data.packaging || '';
            unit.value = data.unit || '';
        }

        function calculateOnInput() {
            const currentQty = parseFloat(qty.value || 0) || 1;
            const currentPrice = parseFloat(price.value || 0);
            const currentDiscount = parseFloat(discount.value || 0);
            const totalAmount = currentQty * (currentPrice - currentDiscount);

            show_grand_total.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(totalAmount);

            total_amount.value = totalAmount; // value for backend
        }

        if(nameProduct)
        {
            nameProduct.addEventListener('change', function() {
                if(this.value) {
                    fetch(`/api/product/${this.value}`)
                        .then( response => response.json() )
                        .then( data => updateFieldProductInfo(packaging, unit, data) )
                        .catch( error => console.error('Error:', error) );
                } else {
                    updateFieldProductInfo(packaging, unit, {});
                }
            })
        }
    </script>
@endpush