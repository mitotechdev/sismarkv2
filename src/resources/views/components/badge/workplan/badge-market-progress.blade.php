@if ($data->market_progress_id == null)
    <span class="badge text-bg-warning">Draf</span>
@else
    <span class="badge text-bg-success">{{ $data->market_progress->name }}</span>
@endif