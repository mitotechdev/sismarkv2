@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Realisasi Kerja</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.edit', $progressWorkplan->workplan_id) }}">Progress</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </section>

    <form action="{{ route('progress-workplan.update', $progressWorkplan->id) }}" method="POST" class="needs-validation" id="editProgress-{{$progressWorkplan->id}}" novalidate>
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-header fw-bold">Form Edit Progress</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-form-label">Tanggal / Market Progress</div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="date" class="form-control" name="date_progress" id="date_progress" title="Tanggal progress" value="{{ $progressWorkplan->date_progress->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <select name="market_progress" class="form-select" title="Market progress" required>
                                        <option value="" selected>Pilih market progress...</option>
                                        @foreach ($marketProgress as $data)
                                            <option value="{{ $data->id }}" {{ $progressWorkplan->market_progress_id == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-form-label">Issue</div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <textarea name="issue" rows="3" placeholder="Tuliskan issue..." class="form-control" title="Deskripsi issue" autocomplete="off" spellcheck="false" required>{{ $progressWorkplan->issue }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-form-label">Next Action</div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <textarea name="next_action" rows="3" placeholder="Tuliskan next action..." class="form-control" title="Deskripsi next action" autocomplete="off" spellcheck="false" required>{{ $progressWorkplan->next_action }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="button" onclick="confirmEdit('editProgress-{{$progressWorkplan->id}}')">Simpan Perubahan</button>
            </div>
        </div>
    </form>

@endsection