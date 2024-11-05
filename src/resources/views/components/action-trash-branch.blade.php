<div class="d-flex gap-1">
    <form action="{{ route('recovery.branch', $branch->id) }}" method="POST" class="d-inline=block" id="recovery-branch-{{$branch->id}}">
        @csrf
        @method('PUT')
        <button type="button" class="btn btn-sm btn-info text-white" onclick="confirmRecovery('{{ $branch->name }}', 'recovery-branch-{{$branch->id}}')">Recovery</button>
    </form>

    <form action="{{ route('delete.permanently.branch', $branch->id) }}" method="POST" class="d-inline-block" id="delete-permanent-branch-{{ $branch->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeletePermanently('{{ $branch->name }}', 'delete-permanent-branch-{{ $branch->id }}')">Delete Permanently</button>
    </form>
</div>