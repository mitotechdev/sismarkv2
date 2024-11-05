@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pricelist</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($message = Session::get('success'))
                        showAlert('Sukses!', '{{ $message }}', 'success');;
                    @endif
                });
            </script>
        @endif

        <div class="card mb-3">
            <form action="{{ route('pricelist.store') }}" method="POST" class="needs-validation form-create" novalidate>
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Pricelist Baru</div>
                <div class="card-body">
                    <div class="row">
                        <label for="product_name" class="col-form-label col-md-3">Nama Produk</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <select class="form-select select-box" oninput="selectProduct(this.value)" name="product_name" id="product_name">
                                            <option value="" selected>Pilih produk...</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" disabled title="Kemasan" id="package">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" disabled title="Satuan" id="unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="price_buy" class="col-form-label col-md-3">Harga Beli</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="number" class="form-control" step=".01" placeholder="0.00" oninput="calculateOnInput()" name="price_buy" id="price_buy" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="price_tax" class="col-form-label col-md-3">Pajak</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select class="form-select" name="tax_rate" id="tax_rate" oninput="calculateOnInput()" title="Pajak" required>
                                            <option value="" selected>Pilih pajak...</option>
                                            @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}" data-value="{{ $tax->tax }}">{{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" disabled readonly id="price_tax" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="price_om" class="col-form-label col-md-3">Ongkos Muat (OM)</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="number" class="form-control" oninput="calculateOnInput()" step=".01" placeholder="0.00" name="price_om" id="price_om" title="Ongkos Muat" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="show_price_unit" class="col-form-label col-md-3">Harga/satuan (Kg)</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="hidden" id="price_unit" name="price_unit">
                                <input type="text" class="form-control" id="show_price_unit" disabled readonly title="Harga/satuan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="name_vendor" class="col-form-label col-md-3">Nama Vendor</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name_vendor" id="name_vendor" title="Nama Vendor" placeholder="PT Example" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="origin" class="col-form-label col-md-3">Wilayah</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="origin" id="origin" title="Wilayah" placeholder="Surabaya" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="category_delivery" class="col-form-label col-md-3">Loco/Franco</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Franco Jakarta" name="category_delivery" id="category_delivery" title="Jenis pengantaran" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="valid_form" class="col-form-label col-md-3">Tanggal Berlaku</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="valid_from" id="valid_from" title="Tanggal berlaku" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="valid_until" id="valid_until" title="Tanggal berakhir" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">Data Pricelist</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 12px"></table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        product_name.addEventListener('change', (e) => {
            selectProduct(e.target.value);
        })
        function selectProduct(data) {
            if(data) {
                const url = '{{ route("api.product.show", ["product" => ":id"]) }}'.replace(':id', data); 
                fetch(url)
                .then(response => response.json())
                .then(item => {
                    package.value = item.packaging;
                    unit.value = item.unit;
                });
            } else {
                package.value = '';
                unit.value = '';    
            }
            
        }
        const config = {
                    search: true,
                    creatable: false,
                    clearable: true,
                    size: '',
                }
        dselect(document.querySelector('.select-box'), config)
        
        function formatCurrency(value) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });
            return formatter.format(value);
        }

        function calculateOnInput() {
            // Get first [data-value] form option select
            const taxValue = tax_rate.options[tax_rate.selectedIndex].getAttribute('data-value');
            const priceBuy  = parseFloat(price_buy.value || 0);
            const taxRate   = parseFloat(taxValue || 0);
            taxAmount = priceBuy * taxRate;
            price_tax.value = formatCurrency(taxAmount);
            // Harga per satuan
            price_unit.value = priceBuy + taxAmount + parseFloat(price_om.value || 0);
            show_price_unit.value = formatCurrency(priceBuy + taxAmount + parseFloat(price_om.value || 0));
        }

        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('pricelist.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'name_product', name: 'name_product', title: 'Produk', orderable: true},
                    { data: 'packaging', name: 'packaging', title: 'Kemasan', orderable: true},
                    { data: 'price_buy', name: 'price_buy', title: 'Harga Beli', orderable: true},
                    { data: 'tax_value', name: 'tax_value', title: 'Pajak', orderable: true},
                    { data: 'price_om', name: 'price_om', title: 'OM', orderable: true},
                    { data: 'price_unit', name: 'price_unit', title: 'Harga Satuan', orderable: true},
                    { data: 'expired_date', name: 'expired_date', title: 'Status', orderable: true},
                    { data: 'name_vendor', name: 'name_vendor', title: 'Vendor', orderable: true},
                    { data: 'category', name: 'category', title: 'Kategori', orderable: true},
                    { data: 'aksi', name: 'aksi', title: 'Aksi', orderable: false},
                ],
            })
        })
    </script>
@endpush