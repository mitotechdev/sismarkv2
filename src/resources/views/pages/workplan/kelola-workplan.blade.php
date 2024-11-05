@extends('layout')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet"/>
@endpush
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Workplan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Kelola Workplan</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <form action="{{ route('workplan.histroy') }}" id="formWorkplan" method="POST" class="needs-validation form-create">
            @csrf
            <input type="hidden" name="workplan_id" value="{{ $workplan->id }}">
            @method('POST')
            <div class="card mb-4">
                <div class="card-header fw-bold">Workplan Terkini</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="market_progress" class="form-label">Jadikan sebagai</label>
                                <select class="form-select select-box" name="market_progress" id="market_progress">
                                    <option value="" selected>Market progress...</option>
                                    @foreach ($marketProgress as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div id="issue" style="font-size: 16px; height: auto;" spellcheck="false"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div id="next_action" style="font-size: 16px; height: auto;" spellcheck="false"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

        {{-- History Workplan --}}
        @php
            use nadar\quill\Lexer;
        @endphp
        <div class="card">
            <div class="card-header fw-bold">History Workplan</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Progress</th>
                            <th>Issue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($historyWorkplans as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->type_progress->name }}</td>
                                <td>
                                    @php
                                        $quillContent = json_decode($data->issue, true);
                                        if (is_array($quillContent)) {
                                            $lexer = new Lexer($quillContent);
                                            echo $lexer->render();
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $quillContent = json_decode($data->next_action, true);
                                        if (is_array($quillContent)) {
                                            $lexer = new Lexer($quillContent);
                                            echo $lexer->render();
                                        }
                                    @endphp
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    <script>
        $('#datatable_sismark').DataTable({
            responsive: true,
        });
        const toolbarOptions = [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
        ];
        
        const quillRemark = new Quill("#issue", {
            modules: {
                toolbar: toolbarOptions,
            },
            theme: 'snow',
            placeholder: 'Tuliskan issue...'
        });

        const quillNextAction = new Quill("#next_action", {
            modules: {
                toolbar: toolbarOptions,
            },
            theme: 'snow',
            placeholder: 'Tuliskan next action...'
        });

        const form = document.querySelector('#formWorkplan');
        form.addEventListener('formdata', (event) => {
            event.formData.append('issue', JSON.stringify(quillRemark.getContents().ops));
            event.formData.append('next_action', JSON.stringify(quillNextAction.getContents().ops));
        });
    </script>
@endpush