@extends('template_backend.home')
@section('heading', 'Presensi Siswa')
@section('page')
    <li class="breadcrumb-item active"><a href="{{ route('siswa.presensi') }}">Presensi siswa</a></li>
    <li class="breadcrumb-item active">{{ $siswa->nama_siswa }}</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('siswa.index') }}" class="btn btn-default btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$data->siswa->nama_siswa}}</td>
                    <td>{{ date('l, d F Y', strtotime($data->tanggal_absen)) }}</td>
                    <td>{{$data->status_kehadiran}}</td>
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
@endsection
@section('script')
    <script>
        $("#AbsensiSiswa").addClass("active");
    </script>
@endsection
