<div class="d-flex gap-1">
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditUser-{{ $user->id }}">Edit</button>
  
    <!-- Modal -->
    <div class="modal fade" id="modalEditUser-{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <form action="{{ route('user.update', $user->id) }}" id="editUser-{{$user->id}}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Informasi Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="employee_id_{{ $unKey }}" class="form-label">NIK Karyawan</label>
                            <input type="text" class="form-control" id="employee_id_{{ $unKey }}" name="employee_id" autocomplete="off" spellcheck="false" value="{{ $user->employee_id }}" title="NIK Karyawan" required>
                        </div>
                        <div class="mb-3">
                            <label for="name_{{ $unKey }}" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" id="name_{{ $unKey }}" name="name" autocomplete="off" spellcheck="false" value="{{ $user->name }}" title="Nama Pengguna" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender_{{ $unKey }}" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="gender" id="gender_{{ $unKey }}" title="Jenis Kelamin" required>
                                <option value="" selected>Pilih...</option>
                                <option value="Pria" {{ $user->gender == "Pria" ? "selected" : "" }}>Pria</option>
                                <option value="Perempuan" {{ $user->gender == "Perempuan" ? "selected" : "" }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phone_{{ $unKey }}" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="phone_{{ $unKey }}" name="phone" autocomplete="off" spellcheck="false" value="{{ $user->phone }}" title="Telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_{{ $unKey }}" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_{{ $unKey }}" name="email" autocomplete="off" spellcheck="false" value="{{ $user->email }}" title="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username_{{ $unKey }}" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_{{ $unKey }}" name="username" autocomplete="off" spellcheck="false" value="{{ $user->username }}" title="Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_{{ $unKey }}" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password_{{ $unKey }}" title="Password">
                                <button class="btn btn-outline-secondary" type="button" onclick="showPassword()">Tampilkan</button>
                            </div>
                            <div class="form-text">Abaikan kolom ini jika anda tidak ingin memperbaharui password.</div>
                        </div>
                        <div class="mb-3">
                            <label for="username_{{ $unKey }}" class="form-label">Branch</label>
                            <select class="form-select" name="branch_id" id="branch_id_{{ $unKey }}" title="Branch ID" required>
                                <option value="" selected>Pilih...</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? "selected" : "" }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="confirmEdit('editUser-{{$user->id}}')">Simpan Perubahan</button>
                    </div>
              </div>
          </div>
      </form>
  </div>
  
  <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline-block" id="deleteUser-{{$user->id}}">
      @csrf
      @method('DELETE')
      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '{{ $user->name}}', 'databases', 'deleteUser-{{$user->id}}' )">Hapus</button>
  </form>
</div>