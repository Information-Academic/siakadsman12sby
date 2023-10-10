@extends('template_backend.home')
@section('heading', 'Rekap Data Permohonan')
@section('page')
  <li class="breadcrumb-item active">Rekap Data Permohonan</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Alasan</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratPermohonan as $data)
                <tr>
                    <td>{{$data->created_at->format('d M Y')}}</td>
                    <td>{{ $data->user->nama_depan }} {{$data->user->nama_belakang}}</td>
                    <td>{{ $data->kehadiran->keterangan }}</td>
                    <td> {!! $data->alasan !!}</td>
                    <td>{{$data->user->roles}}</td>
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
        $("#RekapPermohonanData").addClass("active");
    </script>
@endsection
