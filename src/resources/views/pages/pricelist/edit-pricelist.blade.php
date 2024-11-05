@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('pricelist.index') }}">Pricelist</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        
        <div class="card">
            <form action="{{ route('pricelist.update', $pricelist->id) }}" method="POST" class="needs-validation form-edit" id="editPricelist-{{ $pricelist->id }}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Data Pricelist</div>
                <div class="card-body">
                    <div class="row">
                        <label for="product_name" class="col-form-label col-md-3">Nama Produk</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <select class="form-select select-box" name="product_name" id="product_name">
                                            <option value="" selected>Pilih produk...</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ $product->id == $pricelist->product_id ? "selected" : "" }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" disabled title="Kemasan" value="{{ $pricelist->product->packaging }}" id="package">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" disabled title="Satuan" value="{{ $pricelist->product->unit }}" id="unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="price_buy" class="col-form-label col-md-3">Harga Beli</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="number" class="form-control" step=".01" placeholder="0.00" oninput="calculateOnInput()" name="price_buy" id="price_buy" value="{{ $pricelist->price_buy }}" required>
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
                                                <option value="{{ $tax->id }}" data-value="{{ $tax->tax }}" {{ $tax->id == $pricelist->tax_id ? "selected" : "" }}>{{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        @php
                                            $taxValueBefore = $pricelist->price_buy * $pricelist->tax->tax;
                                        @endphp
                                        <input type="text" disabled readonly id="price_tax" class="form-control" value="Rp {{ number_format($taxValueBefore, 2, ',', '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="price_om" class="col-form-label col-md-3">Ongkos Muat (OM)</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="number" class="form-control" oninput="calculateOnInput()" step=".01" placeholder="0.00" name="price_om" id="price_om" title="Ongkos Muat" value="{{ $pricelist->price_om }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="show_price_unit" class="col-form-label col-md-3">Harga/satuan (Kg)</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                @php
                                    $taxValueBefore = $pricelist->price_buy * $pricelist->tax->tax;
                                    $priceUnitBefore = $taxValueBefore + $pricelist->price_om + $pricelist->price_buy;
                                @endphp
                                <input type="text" class="form-control" id="show_price_unit" disabled readonly title="Harga/satuan" value="Rp {{ number_format($priceUnitBefore, 2, ',', '.') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="name_vendor" class="col-form-label col-md-3">Nama Vendor</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name_vendor" id="name_vendor" title="Nama Vendor" placeholder="PT Example" value="{{ $pricelist->name_vendor }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="origin" class="col-form-label col-md-3">Wilayah</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="origin" id="origin" title="Wilayah" placeholder="Surabaya" value="{{ $pricelist->name_origin }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="category_delivery" class="col-form-label col-md-3">Loco/Franco</label>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Franco Jakarta" name="category_delivery" id="category_delivery" title="Jenis pengantaran" value="{{ $pricelist->category }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="valid_form" class="col-form-label col-md-3">Tanggal Berlaku</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="valid_from" id="valid_from" title="Tanggal berlaku" value="{{ $pricelist->valid_from }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="valid_until" id="valid_until" title="Tanggal berakhir" value="{{ $pricelist->valid_until }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editPricelist-{{ $pricelist->id }}')">Simpan Perubahan</button>
                </div>
            </form>
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
            show_price_unit.value = formatCurrency(priceBuy + taxAmount + parseFloat(price_om.value || 0));
        }
    </script>
@endpush