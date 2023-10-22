@extends('template_backend.home')
@section('heading', 'Data Permohonan Guru')
@section('page')
  <li class="breadcrumb-item active">Data Permohonan Guru</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <table id="example2" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Guru</th>
                    <th>Keterangan</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($status as $data)
                <tr>
                    <td>{{$data->created_at->format('d M Y')}}</td>
                    <td>{{ $data->user->nama_depan }} {{$data->user->nama_belakang}}</td>
                    <td>{{ $data->kehadiran->keterangan }}</td>
                    <td> {!! $data->alasan !!}</td>
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
        $("#Status").addClass("active");
    </script>
@endsection
