@extends('template_backend.home')
@section('heading', 'Data Presensi')
@section('page')
    <li class="breadcrumb-item active"><a href="{{ route('presensikehadiransiswa') }}">Data Presensi</a></li>
    {{-- <li class="breadcrumb-item active">{{ $guru->nama_guru }}</li> --}}
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $data)
                @if ($data->user->roles == 'Siswa')
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$data->user->nama_depan. ' '.$data->user->nama_belakang}}</td>
                    <td>{{$data->user->nis}}</td>
                    <td>
                        {{ date('l, d F Y', strtotime($data->created_at)) }}
                        @if ($data->distance <= 2000)
                        <span class="badge badge-success">Hadir dengan jarak {{number_format($data->distance)}} meter
                        </span>
                        <span class="badge badge-warning">
                            <a href="{{url('/ubahstatus/'.$data->id)}}" class="badge badge-warning">Ubah Status</a>
                            {{Session::get('success')}}
                        </span>
                        @endif
                    </td>
                    {{-- <td>{{$data->kehadiran->keterangan}}</td> --}}
                </tr>
                @endif
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
        $("#PresensiKehadiranSiswa").addClass("active");
    </script>
@endsection
