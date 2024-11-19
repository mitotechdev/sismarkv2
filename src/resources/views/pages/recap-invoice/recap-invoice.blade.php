@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Rekap Invoice</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @can('create-recap-invoice')
    <div class="card mb-3">
        <form action="{{ route('recap-invoice.store') }}" method="POST" class="needs-validation form-create" novalidate>
            @csrf
            @method('POST')
            <div class="card-header">Form Invoice</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="no_purchase_order" class="form-label">Purchase Order <span class="text-danger">*</span></label>
                            <select name="no_purchase_order" id="no_purchase_order" onchange="selectSalesOrder(this.value)" class="form-select select-box" required>
                                <option value="" selected>Cari...</option>
                                @foreach ($salesOrdersWithSisaBayar as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_sales_order }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="name_customer_show" class="form-label">Nama Customer</label>
                            <input type="hidden" name="name_customer" id="name_customer">
                            <input type="text" class="form-control" id="name_customer_show" readonly disabled title="Nama Customer">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="segmen" class="form-label">Segmen</label>
                            <input type="text" class="form-control" id="segmen" readonly disabled title="Segmen Customer">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Sisa Bayar</label>
                            <input type="text" class="form-control" id="sisa_bayar" readonly disabled title="Sisa Bayar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="" class="form-label">List of item purchase order</label>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="table_review_items">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="" class="form-label">No. Invoice <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_invoice" title="Nomor invoice" autocomplete="off" spellcheck="false" placeholder="INV/PKU/XX/XX/XXX" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="date_invoice" class="form-label">Tanggal Invoice <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_invoice" title="Tanggal Invoice"  required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="deadline_invoice" class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="deadline_invoice" id="deadline_invoice" title="Tanggal jatuh tempo"  required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date_payment" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control" name="date_payment" id="date_payment" title="Tanggal bayar">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_payment" class="form-label">Total Bayar <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control" name="total_payment" id="total_payment" title="Total Payment" placeholder="Rp 0" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
    @endcan

    <div class="card mb-3">
        <div class="card-header">Data Invoice</div>
        <div class="card-body">
            <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
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
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('recap-invoice.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'order_date', name: 'order_date', title: 'Order', orderable: true},
                    { data: 'no_sales_order', name: 'no_sales_order', title: 'PO', orderable: true},
                    { data: 'sales', name: 'sales', title: 'Sales', orderable: true},
                    { data: 'customer', name: 'customer', title: 'Customer', orderable: true},
                    { data: 'no_invoice', name: 'no_invoice', title: 'No Invoice', orderable: true},
                    { data: 'date_invoice', name: 'date_invoice', title: 'Date Invoice', orderable: true},
                    { data: 'due_date', name: 'due_date', title: 'Due Date', orderable: true},
                    { data: 'date_payment', name: 'date_payment', title: 'Date Payment', orderable: true, render: function(data) {
                        return data ? new Date(data).toLocaleDateString('id-ID') : `<span class="badge rounded-pill text-bg-warning">Pending</span>`;
                    }},
                    { data: 'total_payment', name: 'total_payment', title: 'Total Payment', orderable: true},
                    { data: 'aksi', name: 'aksi', title: 'Aksi', orderable: false},
                ],
            })
        })

        function selectSalesOrder(data) {
            if(data) {
                fetch(`/report/sales-order/${data}`)
                .then(response => response.json())
                .then(data => {
                    name_customer_show.value = data.customer.name;
                    name_customer.value = data.customer_id;
                    segmen.value = data.customer.category_customer.name;
                    // Clear the table before appending new data
                    const tableBody = document.querySelector("#table_review_items tbody");
                    tableBody.innerHTML = ""; // Reset table content

                    // Populate table rows with sales_order_items data
                    let totalAmount = 0;

                    data.sales_order_items.forEach((item, index) => {
                        const row = document.createElement("tr");

                        // Hitung subtotal setiap item
                        const subtotal = item.qty * item.price;
                        totalAmount += subtotal; // Tambahkan subtotal ke totalAmount

                        // Isi baris dengan data
                        row.innerHTML = `
                            <td class="text-center">${index + 1}</td>
                            <td>${item.product.name}</td>
                            <td>${item.qty} (${item.product ? item.product.unit : ''})</td>
                            <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                            <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                        `;

                        // Tambahkan baris item ke dalam tabel
                        tableBody.appendChild(row);
                    });

                    // Misalnya, ambil persentase PPN dari data tax->name
                    const taxPercentage = data.tax ? parseFloat(data.tax.tax) : 0;
                    const taxAmount = totalAmount * taxPercentage;
                    const grandTotal = totalAmount + taxAmount;

                    // Buat baris PPN
                    const ppnRow = document.createElement("tr");
                    ppnRow.innerHTML = `
                        <th colspan="4">Pajax (${data.tax.name})</th>
                        <th>Rp ${taxAmount.toLocaleString('id-ID')}</th>
                    `;
                    tableBody.appendChild(ppnRow);

                    // Buat baris Grand Total
                    const grandTotalRow = document.createElement("tr");
                    grandTotalRow.innerHTML = `
                        <th colspan="4">Grand Total</th>
                        <th>Rp ${grandTotal.toLocaleString('id-ID')}</th>
                    `;
                    tableBody.appendChild(grandTotalRow);

                    // Menampilkan sisa bayar
                    let totalPayment = 0;
                    data.recap_invoice.forEach((invoice) => {
                        totalPayment += parseFloat(invoice.total_payment);
                    });
                    
                    const remainingPayment = grandTotal - totalPayment;

                    if(totalPayment == grandTotal) {
                        sisa_bayar.value = 'LUNAS';
                    } else {
                        sisa_bayar.value = `Rp ${remainingPayment.toLocaleString('id-ID')}`;
                    }

                    // Validasi jika kelebihan bayar 
                    total_payment.oninput = function() {
                        if(this.value > remainingPayment) {
                            this.value = remainingPayment;
                        }
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
            } else {
                name_customer_show.value = ''; // yang akan ditampilkan
                name_customer.value = '';
                segmen.value = '';
                sisa_bayar.value = '';
                // Clear the table if no data
                document.querySelector("#table_review_items tbody").innerHTML = '';
            }
        }
    </script>
@endpush