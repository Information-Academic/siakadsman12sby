@extends('template_backend.home')
@section('heading', 'Edit Profile')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('profile') }}">Pengaturan</a></li>
  <li class="breadcrumb-item active">Edit Profile</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title text-capitalize">Edit Profile {{ Auth::user()->nama_depan. ' '. Auth::user()->nama_belakang }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('pengaturan.ubah-profile') }}" method="post">
        @csrf
        <div class="card-body">
          @if (Auth::user()->roles == "Guru")
            <div class="row">
              <input type="hidden" name="role" value="{{ Auth::user()->guru(Auth::user()->nip)->roles }}">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="name">Nama Guru</label>
                      <input type="text" id="nama_guru" name="nama_guru" value="{{ Auth::user()->guru(Auth::user()->nip)->nama_guru }}" class="form-control @error('nama_guru') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="mapels_id">Mapel</label>
                      <select id="mapels_id" name="mapels_id" class="select2bs4 form-control @error('mapels_id') is-invalid @enderror">
                          <option value="">-- Pilih Mapel --</option>
                          @foreach ($mapel as $data)
                              <option value="{{ $data->id }}"
                                  @if (Auth::user()->guru(Auth::user()->nip)->mapels_id == $data->id)
                                      selected
                                  @endif
                              >{{ $data->nama_mapel }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="tmp_lahir">Tempat Lahir</label>
                      <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ Auth::user()->guru(Auth::user()->nip)->tempat_lahir }}" class="form-control @error('tempat_lahir') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="telp">Nomor Telepon/HP/WA</label>
                      <input type="text" id="no_telepon" name="no_telepon" onkeypress="return inputAngka(event)" value="{{ Auth::user()->guru(Auth::user()->nip)->no_telepon }}" class="form-control @error('no_telepon') is-invalid @enderror">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="nip">NIP</label>
                      <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" value="{{ Auth::user()->guru(Auth::user()->nip)->nip }}" class="form-control @error('nip') is-invalid @enderror" disabled>
                  </div>
                  <div class="form-group">
                      <label for="jk">Jenis Kelamin</label>
                      <select id="jenis_kelamin" name="jenis_kelamin" class="select2bs4 form-control @error('jenis_kelamink') is-invalid @enderror">
                          <option value="">-- Pilih Jenis Kelamin --</option>
                          <option value="L"
                              @if (Auth::user()->guru(Auth::user()->nip)->jenis_kelamin == 'L')
                                  selected
                              @endif
                          >Laki-Laki</option>
                          <option value="P"
                              @if (Auth::user()->guru(Auth::user()->nip)->jenis_kealmin == 'P')
                                  selected
                              @endif
                          >Perempuan</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="tgl_lahir">Tanggal Lahir</label>
                      <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ Auth::user()->guru(Auth::user()->nip)->tanggal_lahir }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                  </div>
              </div>
            </div>
          @elseif (Auth::user()->roles == "Siswa")
            <div class="row" name="role" value="{{ Auth::user()->siswa(Auth::user()->nis)->roles }}">
              <input type="hidden">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="no_induk">Nomor Induk Siswa</label>
                      <input type="text" id="nis" name="nis" value="{{ Auth::user()->siswa(Auth::user()->nis)->nis}}" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                      <label for="name">Nama Siswa</label>
                      <input type="text" id="nama_siswa" name="nama_siswa" value="{{ Auth::user()->siswa(Auth::user()->nis)->nama_siswa }}" class="form-control @error('nama_siswa') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="jk">Jenis Kelamin</label>
                      <select id="jenis_kelamin" name="jenis_kelamin" class="select2bs4 form-control @error('jenis_kelamin') is-invalid @enderror">
                          <option value="">-- Pilih Jenis Kelamin --</option>
                          <option value="L"
                              @if (Auth::user()->siswa(Auth::user()->nis)->jenis_kelamin == 'L')
                                  selected
                              @endif
                          >Laki-Laki</option>
                          <option value="P"
                              @if (Auth::user()->siswa(Auth::user()->nis)->jenis_kelamin == 'P')
                                  selected
                              @endif
                          >Perempuan</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="tmp_lahir">Tempat Lahir</label>
                      <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ Auth::user()->siswa(Auth::user()->nis)->tempat_lahir }}" class="form-control @error('tempat_lahir') is-invalid @enderror">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="kelas_id">Kelas</label>
                      <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                          <option value="">-- Pilih Kelas --</option>
                          @foreach ($kelas as $data)
                              <option value="{{ $data->id }}"
                                  @if (Auth::user()->siswa(Auth::user()->nis)->kelas_id== $data->id)
                                      selected
                                  @endif
                              >{{ $data->kelas }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="tipe_kelas">Tipe Kelas</label>
                    <select id="tipe_kelas" name="tipe_kelas" class="select2bs4 form-control @error('tipe_kelas') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $data)
                            <option value="{{ $data->id }}"
                                @if (Auth::user()->siswa(Auth::user()->nis)->tipe_kelas== $data->id)
                                    selected
                                @endif
                            >{{ $data->tipe_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                  <div class="form-group">
                      <label for="telp">Nomor Telpon/HP/WA</label>
                      <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ Auth::user()->siswa(Auth::user()->nis)->nomor_telepon }}" onkeypress="return inputAngka(event)" class="form-control @error('nomor_telepon') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="tgl_lahir">Tanggal Lahir</label>
                      <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ Auth::user()->siswa(Auth::user()->nis)->tanggal_lahir }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                  </div>
              </div>
            </div>
          @else
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Nama Depan</label>
                  <input id="nama_depan" type="text" value="{{ Auth::user()->nama_depan }}" class="form-control @error('nama_depan') is-invalid @enderror" name="nama_depan" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Nama Belakang</label>
                    <input id="nama_belakang" type="text" value="{{ Auth::user()->nama_belakang }}" class="form-control @error('nama_belakang') is-invalid @enderror" name="nama_belakang" autocomplete="off">
                  </div>
                </div>
            </div>
          @endif
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
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
            window.location="{{ route('profile') }}";
        });
    });
</script>
@endsection
