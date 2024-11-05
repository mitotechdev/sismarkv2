@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('trash.branch') }}">Branch</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get('restore') || $message = Session::get('deleted'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($message = Session::get('restore'))
                    showAlert('Sukses!', 'Data <b>{{ $message }}</b> berhasil dikembalikan!', 'success');
                @elseif ($message = Session::get('deleted'))
                    showAlert('Sukses!', 'Data <b>{{ $message }}</b> berhasil dihapus secara permanen dari database!', 'success');
                @endif
            });
        </script>
    @endif

    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            Trash Branches
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                <thead>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>NPWP</th>
                    <th>No. Telepon</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('trash.branch') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'Kode', footer: 'Kode' },
                    { data: 'name', name: 'name', title: 'Nama', footer: 'Nama' },
                    { data: 'npwp', name: 'npwp', title: 'NPWP', footer: 'NPWP' },
                    { data: 'phone', name: 'phone', title: 'Telepon', footer: 'Telepon' },
                    { data: 'pic', name: 'pic', title: 'PIC', footer: 'PIC' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
            })
        })
    </script>
@endpush