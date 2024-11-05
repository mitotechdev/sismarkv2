@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Menu Customer</a></li>
              <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">Detail Customer</div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Customer</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->category_customer->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">NPWP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->npwp }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->address }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kota</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->city }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->email }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->phone_number }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Pemilik Perusahaan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->owner }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Branch</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->branch->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Sales</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly disabled value="{{ $customer->user->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Data Klasifikasi</label>
                    <div class="col-sm-9">
                        <textarea rows="4" class="form-control" readonly disabled>{{ $customer->desc_clasification }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Data Technical</label>
                    <div class="col-sm-9">
                        <textarea rows="4" class="form-control" readonly disabled>{{ $customer->desc_technical }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-secondary" href="{{ route('customer.index') }}">Kembali</a>
            </div>
        </div>
    </section>
@endsection