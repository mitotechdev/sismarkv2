@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('recap-invoice.index') }}">Rekap Invoice</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card">
            <form action="{{ route('recap-invoice.update', $recapInvoice->id) }}" method="POST" class="needs-validation" id="formEditRecapInvoice-{{ $recapInvoice->id }}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header">Form Edit</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">No. Invoice <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_invoice" title="Nomor invoice" autocomplete="off" spellcheck="false" placeholder="INV/PKU/XX/XX/XXX" value="{{ $recapInvoice->no_invoice }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_invoice" class="form-label">Tanggal Invoice <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_invoice" title="Tanggal Invoice" value="{{ $recapInvoice->date_invoice->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="deadline_invoice" class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="due_date" id="deadline_invoice" title="Tanggal jatuh tempo" value="{{ $recapInvoice->due_date->format('Y-m-d') }}"  required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_payment" class="form-label">Tanggal Bayar</label>
                                <input type="date" class="form-control" name="date_payment" id="date_payment" title="Tanggal bayar" value="{{ $recapInvoice->date_payment != null ? $recapInvoice->date_payment->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_payment" class="form-label">Sisa Bayar</label>
                                <input type="text" class="form-control" id="sisa_bayar" readonly disabled title="Sisa Bayar">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_payment" class="form-label">Total Bayar <span class="text-danger">*</span></label>
                                <input type="number" step="0.10" class="form-control" name="total_payment" id="total_payment" title="Total Payment" placeholder="Rp 0" value="{{ $recapInvoice->total_payment }}" oninput="validateInputTotalPayment(this.value)" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('formEditRecapInvoice-{{ $recapInvoice->id }}')">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function validateInputTotalPayment(paymentInput) {
            fetch(`{{ route('sales.order.api', $recapInvoice->sales_order_id) }}`)
            .then(response => response.json())
            .then(data => {
                let totalAmount = 0;
                data.sales_order_items.forEach((item, index) => {
                    const subtotal = item.qty * item.price;
                    totalAmount += subtotal;

                })

                const taxPercentage = data.tax ? parseFloat(data.tax.tax) : 0;
                const taxAmount = totalAmount * taxPercentage;
                const grandTotal = totalAmount + taxAmount;

                let totalPayment = 0;
                data.recap_invoice.forEach((invoice) => {
                    totalPayment += parseFloat(invoice.total_payment);
                });
                    
                const remainingPayment = grandTotal - totalPayment;
                sisa_bayar.value = remainingPayment.toLocaleString('id-ID');
                
                if(grandTotal < paymentInput) {
                    // munculkan sweatalert disini
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pembayaran melebihi total sisa bayar!'
                    })
                    total_payment.value = {{ $recapInvoice->total_payment }};
                }
            })
            .catch(error => console.error('Error fetching data:', error));
        }
    </script>
@endpush