@extends('template_backend.home')
@section('heading', 'Presensi Harian Siswa')
@section('page')
  <li class="breadcrumb-item active">Presensi Harian Siswa</li>
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
                    <th>Nama Siswa</th>
                    <th>Status Kehadiran</th>
                    <th width="80px">Jam Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->siswa->nama_siswa }}</td>
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
        <h3 class="card-title">Presensi Harian Siswa</h3>
      </div>
      <form action="{{ route('presensisiswa.simpan') }}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nip">Nomor Induk Siswa</label>
                <input type="text" id="nis" name="nis" onkeypress="return inputAngka(event)" class="form-control @error('nis') is-invalid @enderror">
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
        $("#AbsenSiswa").addClass("active");
    </script>
@endsection
