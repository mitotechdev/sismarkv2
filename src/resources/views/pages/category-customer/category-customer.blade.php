@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Segmen Customer</li>
            </ol>
        </nav>

        @can('create-segment-customer')
        <div class="card mb-3">
            <form action="{{ route('category-customer.store') }}" class="needs-validation form-create" novalidate method="POST">
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Kategori Customer Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="PDAM" title="Nama Kategori" autocomplete="off" spellcheck="false" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
        @endcan

        {{-- Data Category Customer --}}
        <div class="card">
            <div class="card-header fw-bold">Data Kategori Customer</div>
            <div class="card-body">
                {{-- Alert confirmation --}}
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>                    
                @endif

                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px">
                    <thead>
                        <tr>
                            <th class="text-start">No</th>
                            <th>Name</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryCustomers as $data)
                        <tr>
                            <td class="text-start">{{ $loop->iteration }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                @canany(['edit-segment-customer', 'delete-segment-customer'])
                                <div class="d-flex align-items-center gap-2">
                                    @can('edit-segment-customer')
                                    {{-- Button modal --}}
                                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCategory-{{ $data->id }}">
                                        <i class='bx bx-edit' ></i>
                                    </button>
                                    
                                    <!-- Modal -->
                                    <form action="{{ route('category-customer.update', $data->id) }}" method="POST" class="needs-validation" id="confirmEdit-{{$data->id}}" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="modal fade" id="editCategory-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Edit</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <label for="name" class="form-label">Nama Kategori</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="PDAM" value="{{ $data->name }}" title="Nama Kategori" autocomplete="off" spellcheck="false" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary" onclick="if (confirm('Simpan perubahan')) { document.forms['confirmEdit-{{$data->id}}'].submit(); }">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @endcan

                                    @can('delete-segment-customer')
                                    <form action="{{ route('category-customer.destroy', $data->id) }}" method="POST" id="deleteCategory-{{$data->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="button" onclick="commonDelete('deleteCategory-{{$data->id}}')">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                                @endcanany
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
        })
    </script>
@endpush