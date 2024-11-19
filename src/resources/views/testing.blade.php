@extends('layout')
@section('content')
    <section>

        <div class="card">
            <div class="card-body">
                <input type="text" id="content" value="this is content">
                <input type="date" id="date_search" value="2022-01-01">
                <button onclick="filter()">Filter</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function filter() {
            const url = `/testing-response?content=${encodeURIComponent(content.value)}&date_search=${encodeURIComponent(date_search.value)}`;
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response =>  {
                if(!response.ok) {
                    throw new Error('Network response was not ok' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
        }
    </script>
@endpush