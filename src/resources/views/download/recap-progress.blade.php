@extends('layout')

@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Recap Progress</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('print.recap.progress') }}" method="GET" class="needs-validation" novalidate>
                <div class="card-header fw-bold">Form cari data</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales</label>
                                <select name="sales" id="sales" class="form-select select-box" title="Nama sales">
                                    <option value="" selected>Pilih sales...</option>
                                    @foreach ($sales as $data)
                                        <option value="{{ $data->id }}" {{ request()->input('sales') == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_awal" class="form-label">Tanggal awal</label>
                                <input type="date" class="form-control" name="dateMin" id="tanggal_awal" title="Tanggal awal" value="{{ request()->input('dateMin') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal akhir</label>
                                <input type="date" class="form-control" name="dateMax" id="tanggal_akhir" title="Tanggal akhir" value="{{ request()->input('dateMax') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Cari data</button>
                </div>
            </form>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col">Data pencarian</div>
                    <div class="col text-end">
                        @if ($dataSearch != null)
                            <form action="{{ route('export.progress') }}" method="POST" target="_blank">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="sales" value="{{ request()->input('sales') }}">
                                <input type="hidden" name="dateMin" value="{{ request()->input('dateMin') }}">
                                <input type="hidden" name="dateMax" value="{{ request()->input('dateMax') }}">
                                <button class="btn btn-sm btn-outline-primary" type="submit">Export Data</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($dataSearch != null)
                    <table class="table table-hover align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>ID</th>
                                <th>Sales</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Market Progress</th>
                                <th>Issue</th>
                                <th>Next Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSearch as $item)
                            <tr>
                                <td class="text-start py-3">{{ $loop->iteration }}</td>
                                <td>{{ $item->code_progress }}</td>
                                <td>{{ $item->sales->name }}</td>
                                <td>{{ $item->date_progress->format('d/m/Y') }}</td>
                                <td>{{ $item->workplan->customer->name }}</td>
                                <td>{{ $item->market_progress->name }}</td>
                                <td>{{ $item->issue }}</td>
                                <td>{{ $item->next_action }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>     
                @else
                    <div class="alert alert-warning">Cari data terlebih dahulu!</div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
            });
        });
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