@extends('template_backend.home')
@section('heading', 'Data Presensi')
@section('page')
    <li class="breadcrumb-item active"><a href="{{ route('presensikehadiran') }}">Data Presensi</a></li>
    {{-- <li class="breadcrumb-item active">{{ $guru->nama_guru }}</li> --}}
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>NIP</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $data)
                @if ($data->distance <=1000)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$data->user->nama_depan. ' '.$data->user->nama_belakang}}</td>
                    <td>{{$data->user->nis}}</td>
                    <td>{{$data->user->nip}}</td>
                    <td>{{ date('l, d F Y', strtotime($data->created_at)) }}</td>
                    <td>
                        @if ($data->distance <= 1000)
                            <span class="badge badge-success">Hadir dengan jarak {{number_format($data->distance)}} KM</span>
                        {{-- @else
                            <span class="badge badge-danger">Tidak Hadir. Jarak sekolah dengan user {{number_format($data->distance)}} KM</span> --}}
                        @endif
                    </td>
                    {{-- <td>{{$data->kehadiran->keterangan}}</td> --}}
                    <td>{{$data->user->roles}}</td>
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
        $("#PresensiData").addClass("active");
    </script>
@endsection
