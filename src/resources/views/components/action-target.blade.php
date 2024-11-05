<div class="d-flex gap-1">
    <a href="" class="btn btn-sm btn-info">Lihat</a>
    <a href="{{ route('target.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('target.destroy', $data->id) }}" method="POST" id="dataTarget{{$random}}">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" type="button" onclick="commonDelete('dataTarget{{$random}}')">Hapus</button>
    </form>
</div>