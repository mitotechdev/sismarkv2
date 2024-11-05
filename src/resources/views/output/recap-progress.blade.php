<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Progress</title>
    <link rel="stylesheet" href="{{ public_path('/css/recap-progress.css') }}">
</head>
<body>
    <div class="wrapper text-center">
        <strong>LAPORAN REKAP PROGRESS KERJA SALES MARKETING</strong>
        <br>
        {{ date('d/m/Y', strtotime($searchData->dateMin)) }} - {{ date('d/m/Y', strtotime($searchData->dateMax)) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Sales</th>
                <th>Customer</th>
                <th>Segmen</th>
                <th>Market Progress</th>
                <th>Status</th>
                <th>Deskripsi</th>
                <th>Next Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataProgress as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y', strtotime($data->date_progress)) }}</td>
                <td>{{ $data->sales->name }}</td>
                <td>{{ $data->workplan->customer->name }}</td>
                <td>{{ $data->workplan->customer->category_customer->name }}</td>
                <td>{{ $data->market_progress->name }}</td>
                <td>{{ $data->market_progress->status }}</td>
                <td>{{ $data->issue }}</td>
                <td>{{ $data->next_action }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>