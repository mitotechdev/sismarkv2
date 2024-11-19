@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Customer</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    @can('create-customer')
    <div class="card mb-3">
        <form action="{{ route('customer.store') }}" method="POST" class="needs-validation form-create" novalidate>
            @csrf
            @method('POST')
            <div class="card-header fw-bold">Data Baru</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name_customer" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" id="name_customer" name="name_customer" autocomplete="off" spellcheck="false" placeholder="PT Example" title="Nama Customer" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category_customer" class="form-label">Kategori Customer</label>
                            <select name="category_customer" id="category_customer" class="form-select select-box" title="Kategori Customer" required>
                                <option value="" selected>Pilih kategori...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="npwp" class="form-label">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp" autocomplete="off" spellcheck="false" placeholder="XX.XXXX.XXXX.XXXX" title="NPWP" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address" autocomplete="off" spellcheck="false" placeholder="Jl. Example, No. 1 Pekanbaru" title="Alamat" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="city" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="city" name="city" autocomplete="off" spellcheck="false" placeholder="Kota Pekanbaru" title="Kota" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" spellcheck="false" title="Email" placeholder="company@example.com" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" autocomplete="off" spellcheck="false" placeholder="(0761) XXXXXX" title="Nomor Telepon" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="name_owner" class="form-label">Pemilik Perusahaan</label>
                            <input type="text" class="form-control" id="name_owner" name="name_owner" autocomplete="off" spellcheck="false" placeholder="Tn. Example" title="Pemilik Perusahaan" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="branch_system" class="form-label">Branch Sistem</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->branch->name }}" disabled readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="pic_sales" class="form-label">PIC Sales</label>
                            <select name="pic_sales" id="pic_sales" class="form-select select-box" required>
                                <option value="" selected>Pilih sales...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="desc_clasification" class="form-label">Data Klasifikasi</label>
                            <textarea name="desc_clasification" id="desc_clasification" rows="4" title="Data Klasifikasi" class="form-control" spellcheck="false" autocomplete="off" placeholder="Tuliskan data klasifikasi..." required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="desc_technical" class="form-label">Data Teknikal</label>
                            <textarea name="desc_technical" id="desc_technical" rows="4" title="Data Teknikal" class="form-control" autocomplete="off" spellcheck="false" placeholder="Tuliskan data teknikal..." required></textarea>
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

    <div class="card">
        <div class="card-header fw-bold">Data Customer</div>
        <div class="card-body">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px;"></table>
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
                ajax: "{{ route('customer.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'name', name: 'name', title: 'Nama Konsumen', searchable: true },
                    { data: 'category_customer', name: 'category_customer', title: 'Kategori', orderable: true, searchable: true},
                    { data: 'npwp', name: 'npwp', title: 'NPWP', searchable: true },
                    { data: 'city', name: 'city', title: 'Kota', searchable: true },
                    { data: 'sales_name', name: 'sales_name', title: 'Sales', searchable: true },
                    { data: 'status', name: 'status', title: 'Status', render: function(data) {
                        return '<span class="badge bg-' + data.tag_front_end + '">' + data.name_status + '</span>';
                    } },
                    { data: 'aksi', name: 'aksi', title: 'Aksi'},
                ]
            });
        });
    </script>
@endpush