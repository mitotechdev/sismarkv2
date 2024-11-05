<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#showDetailCustomer-{{ $random }}">{{ $customer->name }}</button>

<div class="modal fade" id="showDetailCustomer-{{ $random }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Data Konsumen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="mb-5">{{ $customer->name }}</h3>
                <div class="row mb-3">
                    <label for="type_business_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Deskripsi</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="type_business_{{$random}}" readonly disabled value="{{ $customer->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Kategori</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="category_{{$random}}" readonly disabled value="xxx">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="npwp_{{$random}}" class="col-md-3 col-lg-2 col-form-label">NPWP</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="npwp_{{$random}}" readonly disabled value="{{ $customer->npwp }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="owner_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Pemilik Perusahaan</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="owner_{{$random}}" readonly disabled value="{{ $customer->owner }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Alamat</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="address_{{$random}}" readonly disabled value="{{ $customer->address }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="city_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Kota</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="city_{{$random}}" readonly disabled value="{{ $customer->city }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Email</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="email_{{$random}}" readonly disabled value="{{ $customer->email }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Telepon</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="phone_{{$random}}" readonly disabled value="{{ $customer->phone_number }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="desc_technical_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Data Teknikal</label>
                    <div class="col-md-9 col-lg-10">
                        <textarea class="form-control" id="desc_technical_{{$random}}" rows="3" title="Data Teknikal" readonly disabled>{{$customer->desc_technical}}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="desc_clasification_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Data Klasifikasi</label>
                    <div class="col-md-9 col-lg-10">
                        <textarea class="form-control" id="desc_clasification_{{$random}}" rows="3" title="Data Klasifikasi" readonly disabled>{{$customer->desc_clasification}}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="branch_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Branch Sistem</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="branch_{{$random}}" readonly disabled value="{{ $customer->branch->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sales_{{$random}}" class="col-md-3 col-lg-2 col-form-label">Sales</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" class="form-control" id="sales_{{$random}}" readonly disabled value="{{ $customer->user->name ?? 'N/A' }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>