@extends('template_backend.home')
@section('heading', 'Data Siswa')
@section('page')
  <li class="breadcrumb-item active">Data Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Siswa
                </button>
            </h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kelas</th>
                    <th>Tipe Kelas</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->kelas }}</td>
                        <td>{{ $data->tipe_kelas }}</td>
                        <td>{{ $data->tahun }}</td>
                        <td>
                            <a href="{{ route('siswa.kelas', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Tambah Data Siswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('siswa.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_induk">Nomor Induk Siswa</label>
                        <input type="text" id="nis" name="nis" onkeypress="return inputAngka(event)" class="form-control @error('nis') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Siswa</label>
                        <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="select2bs4 form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="foto_siswa">Foto Siswa</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="foto_siswa" class="custom-file-input @error('foto_siswa') is-invalid @enderror" id="foto_siswa">
                                <label class="custom-file-label" for="foto_siswa">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas2 as $data)
                                <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Tipe Kelas</label>
                        <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $data)
                                <option value="{{ $data->id }}">{{ $data->tipe_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telpon/HP/WA</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon" onkeypress="return inputAngka(event)" class="form-control @error('nomor_telepon') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror">
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
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataSiswa").addClass("active");
    </script>
@endsection
