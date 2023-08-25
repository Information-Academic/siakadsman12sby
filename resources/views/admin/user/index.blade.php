@extends('template_backend.home')
@section('heading', 'Data User')
@section('page')
  <li class="breadcrumb-item active">Data User</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-user">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data User
                </button>
                <button type="button" class="btn btn-success btn-sm my-3" data-toggle="modal" data-target="#importExcel">
                  <i class="nav-icon fas fa-file-import"></i> &nbsp; IMPORT EXCEL
                </button>
            </h3>
        </div>
        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('user.import_excel') }}" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">
                  @csrf
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="modal-title">Petunjuk : (Gunakan ekstensi .xlsx dan .csv untuk dapat melakukan import file agar bisa terbaca dengan baik)</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>rows 1 = Nama Depan</li>
                                <li>rows 2 = Nama Belakang (Opsional)</li>
                                <li>rows 3 = Nama Pengguna</li>
                                <li>rows 4 = Email</li>
                                <li>rows 5 = Password</li>
                                <li>rows 6 = Roles</li>
                                <li>rows 7 = NIS (Nomor Induk Siswa)</li>
                                <li>rows 8 = NIP (Nomor Induk Pegawai)</li>
                            </ul>
                        </div>
                    </div>
                    <label>Pilih file excel</label>
                    <div class="form-group">
                      <input type="file" name="file" required="required">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Level User</th>
                    <th>Jumlah User</th>
                    <th>Lihat User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $role => $data)
                  <tr>
                    <td>{{ $role }}</td>
                    <td>{{ $data->count() }}</td>
                    <td>
                      <a href="{{ route('user.show', Crypt::encrypt($role)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md tambah-user" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('user.store') }}" method="post">
          @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Nama Depan</label>
                    <input id="nama_depan" type="text" placeholder="Masukkan Nama Depan" class="form-control" name="nama_depan" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="name">Nama Belakang</label>
                    <input id="nama_belakang" type="text" placeholder="Masukkan Nama Belakang (Opsional)" class="form-control" name="nama_belakang" autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label for="name">Nama Pengguna</label>
                    <input id="nama_pengguna" type="text" placeholder="Masukkan Nama Pengguna" class="form-control" name="nama_pengguna" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="email">E-Mail Address</label>
                  <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="role">Level User</label>
                  <select id="roles" type="text" class="form-control @error('roles') is-invalid @enderror select2bs4" name="roles" value="{{ old('roles') }}" autocomplete="roles">
                    <option value="">-- Select {{ __('Level User') }} --</option>
                    <option value="Admin">Admin</option>
                    <option value="Guru">Guru</option>
                    <option value="Siswa">Siswa</option>
                  </select>
                  @error('roles')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group" id="noId">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password-confirm">Confirm Password</label>
                  <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </form>
    </div>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script>
    $(document).ready(function(){
        $('#roles').change(function(){
            var kel = $('#roles option:selected').val();
            if (kel == "Guru") {
              $("#noId").html('<label for="nomer">NIP</label><input id="nomer" type="text" maxlength="5" onkeypress="return inputAngka(event)" placeholder="NIP" class="form-control" name="nomer" autocomplete="off">');
            } else if(kel == "Siswa") {
              $("#noId").html(`<label for="nomer">Nomer Induk Siswa</label><input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="off">`);
            }  else {
              $("#noId").html("")
            }
        });
    });
    
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataUser").addClass("active");
  </script>
@endsection