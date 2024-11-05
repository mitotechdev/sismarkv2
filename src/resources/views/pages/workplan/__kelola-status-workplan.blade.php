@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Workplan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Kelola Status</li>
            </ol>
        </nav>

        <div class="card">
            <form action="{{ route('workplan.update.status', $workplan->id) }}" method="POST" class="needs-validation form-edit" id="updateStatusWorkplan-{{$workplan->id}}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header">Informasi Workplan</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name_sales" class="form-label">Nama Sales</label>
                                <input type="text" class="form-control" disabled readonly value="{{ $workplan->sales->name }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name_customer" class="form-label">Customer</label>
                                <input type="text" class="form-control" disabled readonly value="{{ $workplan->name_customer }}" title="Nama customer">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="category_customer" class="form-label">Kategori Customer</label>
                                <input type="text" class="form-control" disabled readonly value="{{ $workplan->category_customer }}" title="Kategori customer">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="progress" class="form-label">Progress</label>
                                <input type="text" class="form-control" disabled readonly value="{{ $workplan->market_progress->name }}" title="Market Progress">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="update_status" class="form-label">Status</label>
                                <select name="update_status" id="update_status" title="Status terbaru" class="form-select select-box" required>
                                    <option value="">Pilih status...</option>
                                    <option value="1" {{ $workplan->status == 1 ? "selected" : "" }}>Progress</option>
                                    <option value="2" {{ $workplan->status == 2 ? "selected" : "" }}>Done</option>
                                    <option value="3" {{ $workplan->status == 3 ? "selected" : "" }}>Reject</option>
                                    <option value="4" {{ $workplan->status == 4 ? "selected" : "" }}>Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" onclick="confirmEdit('updateStatusWorkplan-{{$workplan->id}}')">Submit</button>
                </div>
            </form>
        </div>
    </section>
@endsection