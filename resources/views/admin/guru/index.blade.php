@extends('template_backend.home')
@section('heading', 'Data Guru')
@section('page')
  <li class="breadcrumb-item active">Data Guru</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Guru
                </button>
            </h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Mapel</th>
                    <th>Lihat Guru</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mapel as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_mapel }}</td>
                        <td>
                            <a href="{{ route('guru.mapel', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Tambah Data Guru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input type="text" id="nama_guru" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Guru</label>
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
                        <label for="no_telepon">Nomor Telpon/HP</label>
                        <input type="text" id="no_telepon" name="no_telepon" onkeypress="return inputAngka(event)" class="form-control @error('no_telepon') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group after-add-more">
                        <div class="form-group delete">
                        <label for="mapels_id">Mapel</label>
                        <div class="copy hapus hide">
                        <select multiple id="mapels_id" name="mapels_id[]" class="select2bs4 form-control @error('mapels_id') is-invalid @enderror">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach ($mapel as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_mapel }}</option>
                            @endforeach
                        </select>
                        <hr>
                        </div>
                        </div>
                    </div>
                    @php
                        $kode = $max+1;
                        if (strlen($kode) == 1) {
                            $nip = "0000".$kode;
                        } else if(strlen($kode) == 2) {
                            $nip = "000".$kode;
                        } else if(strlen($kode) == 3) {
                            $nip = "00".$kode;
                        } else if(strlen($kode) == 4) {
                            $nip = "0".$kode;
                        } else {
                            $nip = $kode;
                        }
                    @endphp
                    <div class="form-group">
                        <label for="nip">Nomor Induk Pegawai</label>
                        <input type="text" id="nip" name="nip" maxlength="5" onkeypress="return inputAngka(event)" value="{{ $nip }}" class="form-control @error('nip') is-invalid @enderror" readonly>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Guru</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                                <label class="custom-file-label" for="foto">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status_guru">Status Guru</label>
                        <select id="status_guru" name="status_guru" class="select2bs4 form-control @error('status_guru') is-invalid @enderror">
                            <option value="">-- Pilih Status Guru --</option>
                            <option value="Pns">PNS</option>
                            <option value="Honorer">Honorer</option>
                            <option value="Tidak Tetap">Tidak Tetap</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_pegawai">Status Pegawai</label>
                        <select id="status_pegawai" name="status_pegawai" class="select2bs4 form-control @error('status_pegawai') is-invalid @enderror">
                            <option value="">-- Pilih Status Pegawai --</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
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
        $("#DataGuru").addClass("active");
    </script>
@endsection
