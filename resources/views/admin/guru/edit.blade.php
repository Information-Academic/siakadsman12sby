@extends('template_backend.home')
@section('heading', 'Edit Guru')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('guru.index') }}">Guru</a></li>
  <li class="breadcrumb-item active">Edit Guru</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Guru</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('guru.update', $guru->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ $guru->nama_guru }}" class="form-control @error('nama_guru') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="mapels_id">Mapel</label>
                    <select multiple id="mapels_id" name="mapels_id" class="select2bs4 form-control @error('mapels_id') is-invalid @enderror">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $data)
                            <option value="{{ $data->id }}"
                                @if ($guru->mapels_id == $data->id)
                                    selected
                                @endif
                            >{{ $data->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ $guru->tempat_lahir }}" class="form-control @error('tempat_lahir') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="nip">Nomor Induk Pegawai</label>
                    <input type="text" id="nip" name="nip" class="form-control" value="{{ $guru->nip }}" readonly>
                </div>
                <div class="form-group">
                    <label for="no_telepon">Nomor Telpon/HP</label>
                    <input type="text" id="no_telepon" name="no_telepon" onkeypress="return inputAngka(event)" value="{{ $guru->no_telepon }}" class="form-control @error('no_telepon') is-invalid @enderror">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="select2bs4 form-control @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L"
                            @if ($guru->jenis_kelamin == 'L')
                                selected
                            @endif
                        >Laki-Laki</option>
                        <option value="P"
                            @if ($guru->jenis_kelamin == 'P')
                                selected
                            @endif
                        >Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $guru->tanggal_lahir }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="alamat_guru">Alamat Guru</label>
                    <input type="text" id="alamat_guru" name="alamat_guru" value="{{ $guru->alamat_guru }}" class="form-control @error('alamat_guru') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="status_guru">Status Guru</label>
                    <select id="status_guru" name="status_guru" class="select2bs4 form-control @error('status_guru') is-invalid @enderror">
                        <option value="">-- Pilih Status Guru --</option>
                        <option value="Pns"
                            @if ($guru->status_guru == 'Pns')
                                selected
                            @endif
                        >PNS</option>
                        <option value="Honorer"
                            @if ($guru->jenis_kelamin == 'Honorer')
                                selected
                            @endif
                        >Honorer</option>
                        <option value="Tidak Tetap"
                            @if ($guru->jenis_kelamin == 'Tidak Tetap')
                                selected
                            @endif
                        >Tidak Tetap</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_pegawai">Status Pegawai</label>
                    <select id="status_pegawai" name="status_pegawai" class="select2bs4 form-control @error('status_pegawai') is-invalid @enderror">
                        <option value="">-- Pilih Status Pegawai --</option>
                        <option value="Aktif"
                            @if ($guru->status_pegawai == 'Aktif')
                                selected
                            @endif
                        >Aktif</option>
                        <option value="Tidak Aktif"
                            @if ($guru->status_pegawai == 'Tidak Aktif')
                                selected
                            @endif
                        >Tidak Aktif</option>
                    </select>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#back').click(function() {
        window.location="{{ route('guru.mapel', Crypt::encrypt($guru->mapels_id)) }}";
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataGuru").addClass("active");
</script>
@endsection
