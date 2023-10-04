@extends('template_backend.home')
@section('heading', 'Edit Siswa')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('siswa.index') }}">Siswa</a></li>
  <li class="breadcrumb-item active">Edit Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Siswa</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('siswa.update', $siswa->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ $siswa->nama_siswa }}" class="form-control @error('nama_siswa') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="select2bs4 form-control @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L"
                            @if ($siswa->jenis_kelamin == 'L')
                                selected
                            @endif
                        >Laki-Laki</option>
                        <option value="P"
                            @if ($siswa->jenis_kelamin == 'P')
                                selected
                            @endif
                        >Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Siswa</label>
                    <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{$siswa->alamat}}">
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}" class="form-control @error('tempat_lahir') is-invalid @enderror">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" onkeypress="return inputAngka(event)" value="{{ $siswa->nis }}" class="form-control @error('nis') is-invalid @enderror" readonly>
                </div>
                <div class="form-group">
                    <label for="kelas_id">Kelas</label>
                    <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $data)
                            <option value="{{ $data->id }}"
                                @if ($siswa->kelas_id == $data->id)
                                    selected
                                @endif
                            >{{ $data->kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelas_id">Tipe kelas</label>
                    <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                        <option value="">-- Pilih Tipe Kelas --</option>
                        @foreach ($kelas as $data)
                            <option value="{{ $data->id }}"
                                @if ($siswa->kelas_id == $data->id)
                                    selected
                                @endif
                            >{{ $data->tipe_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telpon/HP/WA</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $siswa->nomor_telepon }}" onkeypress="return inputAngka(event)" class="form-control @error('nomor_telepon') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
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
        window.location="{{ route('siswa.kelas', Crypt::encrypt($siswa->kelas_id)) }}";
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataSiswa").addClass("active");
</script>
@endsection
