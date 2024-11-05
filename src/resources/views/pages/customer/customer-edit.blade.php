@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
              <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('customer.update', $customer->id) }}" id="editCustomer-{{ $customer->id }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Data Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name_customer" class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" id="name_customer" name="name_customer" autocomplete="off" spellcheck="false" placeholder="PT Example" title="Nama Customer" value="{{ $customer->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="category_customer" class="form-label">Kategori Customer</label>
                                <select name="category_customer" id="category_customer" class="form-select select-box" title="Kategori Customer" required>
                                    <option value="" selected>Pilih kategori...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $customer->category_customer_id == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="npwp" class="form-label">NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" autocomplete="off" spellcheck="false" placeholder="XX.XXXX.XXXX.XXXX" title="NPWP" value="{{ $customer->npwp }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" autocomplete="off" spellcheck="false" placeholder="Jl. Example, No. 1 Pekanbaru" title="Alamat" value="{{ $customer->address }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="city" name="city" autocomplete="off" spellcheck="false" placeholder="Kota Pekanbaru" title="Kota" value="{{ $customer->city }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" autocomplete="off" spellcheck="false" title="Email" placeholder="company@example.com" value="{{ $customer->email }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" autocomplete="off" spellcheck="false" placeholder="(0761) XXXXXX" title="Nomor Telepon" value="{{ $customer->phone_number }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name_owner" class="form-label">Pemilik Perusahaan</label>
                                <input type="text" class="form-control" id="name_owner" name="name_owner" autocomplete="off" spellcheck="false" placeholder="Tn. Example" title="Pemilik Perusahaan" value="{{ $customer->owner }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="branch_system" class="form-label">Branch Sistem</label>
                                <select name="branch_system" id="branch_system" class="form-select select-box" required>
                                    <option value="" selected>Pilih branch...</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $customer->branch_id == $branch->id ? "selected" : "" }}>{{ $branch->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pic_sales" class="form-label">PIC Sales</label>
                                <select name="pic_sales" id="pic_sales" class="form-select select-box" required>
                                    <option value="" selected>Pilih sales...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $customer->user_id == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="desc_clasification" class="form-label">Data Klasifikasi</label>
                                <textarea name="desc_clasification" id="desc_clasification" rows="4" title="Data Klasifikasi" class="form-control" spellcheck="false" autocomplete="off" placeholder="Tuliskan data klasifikasi..." required>{{ $customer->desc_clasification }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="desc_technical" class="form-label">Data Teknikal</label>
                                <textarea name="desc_technical" id="desc_technical" rows="4" title="Data Teknikal" class="form-control" autocomplete="off" spellcheck="false" placeholder="Tuliskan data teknikal..." required>{{ $customer->desc_technical }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editCustomer-{{ $customer->id }}')">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
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
    </script>
@endpush