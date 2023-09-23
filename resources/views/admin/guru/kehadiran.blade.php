@extends('template_backend.home')
@section('heading', 'Presensi Guru')
@section('page')
    <li class="breadcrumb-item active"><a href="{{ route('guru.presensi') }}">Presensi guru</a></li>
    <li class="breadcrumb-item active">{{ $guru->nama_guru }}</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('guru.index') }}" class="btn btn-default btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Guru</th>
                    <th>Tanggal</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$data->guru->nama_guru}}</td>
                    <td>{{ date('l, d F Y', strtotime($data->tanggal_absen)) }}</td>
                    <td>{{$data->kehadirans->keterangan}}</td>
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
        $("#AbsensiGuru").addClass("active");
    </script>
@endsection
