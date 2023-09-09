@extends('template_backend.home')
@section('heading', 'Edit Data Status Kelas')
@section('page')
  {{-- <li class="breadcrumb-item active"><a href="{{ route('kelas.index') }}">Kelas</a></li> --}}
  <li class="breadcrumb-item active">Edit Data Status Kelas</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Data Kelas</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('kelas.store')}}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
              <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <input type="text" value="{{$kelas->kelas}}" id="kelas" name='kelas' class="form-control @error('kelas') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="tipe_kelas">Tipe Kelas</label>
                    <input type="text" value="{{$kelas->tipe_kelas}}" id="tipe_kelas" name='tipe_kelas' class="form-control @error('tipe_kelas') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="tipe_kelas">Tahun</label>
                    <input type="text" value="{{$kelas->tahun}}" id="tahun" name='tahun' class="form-control @error('tahun') is-invalid @enderror">
                </div>
                <div class="form-group">
                  <label for="status_kelas">Status Kelas</label>
                  <select name="status_kelas" class="form-control @error('status_kelas') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Status Kelas --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="gurus_id">Nama Guru</label>
                    <select id="gurus_id" name="gurus_id" class="form-control @error('gurus_id') is-invalid @enderror select2bs4">
                        <option value="">-- Pilih Nama Guru --</option>
                        @foreach ($guru as $data)
                            <option value="{{ $data->id }}"
                              @if ($kelas->gurus_id == $data->id)
                                selected
                              @endif
                            >{{ $data->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
            <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
          </div>
      </form>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#back').click(function() {
        window.location="{{ route('kelas.index', Crypt::encrypt($kelas->id)) }}";
        });
    });
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataJadwal").addClass("active");
</script>
@endsection
