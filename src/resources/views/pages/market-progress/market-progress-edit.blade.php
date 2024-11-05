@extends('layout')

@section('content')

    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('market-progress.index') }}">Market Progress</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('market-progress.update', $marketProgress->id) }}" method="POST" class="needs-validation" id="editMarketProgress-{{$marketProgress->id}}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Form Edit Market Progress</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Progress</label>
                                <input type="text" class="form-control" name="name" id="name" autocomplete="off" spellcheck="false" placeholder="Mapping" value="{{ $marketProgress->name }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" autocomplete="off" spellcheck="false" placeholder="Prospect" value="{{ $marketProgress->status }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editMarketProgress-{{$marketProgress->id}}')">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>

@endsection