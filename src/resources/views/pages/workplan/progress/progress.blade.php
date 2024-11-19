@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Realisasi Kerja</a></li>
              <li class="breadcrumb-item active" aria-current="page">Progress</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif($message = Session::get('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class='bx bx-sm bxs-info-circle me-1'></i>
            <span> {{ $message }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Display data workplan --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label text-muted">Sales</label>
                    <div class="form-label h6">{{ $workplan->sales->name }}</div>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label text-muted">Customer</label>
                    <div class="form-label h6">{{ $workplan->customer->name }}</div>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label text-muted">Segmen</label>
                    <div class="form-label h6">{{ $workplan->customer->category_customer->name }}</div>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label text-muted">Market Progress</label>
                    @if ($workplan->market_progress_id == null)
                        <div class="form-label">
                            <span class="badge text-bg-warning">Draf</span>
                        </div>
                    @else
                        <div class="form-label">
                            <span class="badge text-bg-success">{{ $workplan->market_progress->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @can('create-progress')
        @if(auth()->user()->id == $workplan->sales_id)
        <form action="{{ route('progress-workplan.store') }}" method="POST" class="needs-validation form-create" novalidate>
            @csrf
            @method('POST')
            <input type="hidden" name="workplan_id" value="{{ $workplan->id }}">
            <div class="card mb-3">
                <div class="card-header fw-bold">Form Progress Terbaru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-form-label">Tanggal / Market Progress</div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="date_progress" id="date_progress" title="Tanggal progress" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="market_progress" class="form-select" title="Market progress" required>
                                            <option value="" selected>Pilih market progress...</option>
                                            @foreach ($marketProgress as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                                <textarea name="issue" rows="3" placeholder="Tuliskan issue..." class="form-control" title="Deskripsi issue" autocomplete="off" spellcheck="false" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-form-label">Next Action</div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <textarea name="next_action" rows="3" placeholder="Tuliskan next action..." class="form-control" title="Deskripsi next action" autocomplete="off" spellcheck="false" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
        @endif
    @endcan

    <div class="card">
        <div class="card-header fw-bold">Rekap Progress</div>
        <div class="card-body">
            <table class="table table-striped align-middle" id="datatable_sismark" style="font-size: 14px; width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Market Progress</th>
                        <th>Issue</th>
                        <th>Next Action</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($progressWorkplans as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->date_progress->format('d/m/Y') }}</td>
                            <td>{{ $data->market_progress->name }}</td>
                            <td>{{ $data->issue }}</td>
                            <td>{{ $data->next_action }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @can('edit-progress')
                                    <a class="btn btn-sm btn-outline-warning" href="{{ route('progress-workplan.edit', $data->id) }}">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    @endcan
                                    @can('delete-progress')
                                    <form action="{{ route('progress-workplan.destroy', $data->id) }}" method="POST" id="deleteProgress-{{ $data->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="button" onclick="commonDelete('deleteProgress-{{ $data->id }}')">
                                            <i class='bx bx-trash-alt'></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
            });
        })
    </script>
@endpush