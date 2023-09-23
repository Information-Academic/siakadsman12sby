@extends('template_backend.home')
@section('heading', 'Presensi Harian Guru')
@section('page')
  <li class="breadcrumb-item active">Presensi Harian guru</li>
@endsection
@section('content')
@php
    $no = 1;
@endphp
<div class="col-md-6">
    <div class="card">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Status Kehadiran</th>
                    <th width="80px">Jam Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->guru->nama_guru }}</td>
                        <td>{{ $data->status_kehadiran }}</td>
                        <td>{{ $data->created_at->format('H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Presensi Harian Guru</h3>
      </div>
      <form action="{{ route('presensi.simpan') }}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nip">Nomor Induk Pegawai</label>
                <input type="text" id="nip" name="nip" maxlength="5" onkeypress="return inputAngka(event)" class="form-control @error('nip') is-invalid @enderror">
            </div>
            <div class="form-group">
              <label for="status_kehadiran">Keterangan Kehadiran</label>
              <select id="status_kehadiran" type="text" class="form-control @error('status_kehadiran') is-invalid @enderror select2bs4" name="status_kehadiran">
                <option value="">-- Pilih Keterangan Kehadiran --</option>
                @foreach ($kehadiran as $data)
                  <option value="{{ $data->id }}">{{ $data->keterangan }}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="card-footer">
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Presensi Sekarang </button>
        </div>
      </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#AbsenGuru").addClass("active");
    </script>
@endsection
