@extends('template_backend.home')
@section('heading', 'Data Nilai Rapor')
@section('page')
  <li class="breadcrumb-item active">Data Nilai Rapor</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12" style="margin-top: -21px;">
                <table class="table">
                    <tr>
                        <td>Nama Guru</td>
                        <td>:</td>
                        <td>{{ $guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel }}</td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
              <table id="example2" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                  @foreach ($kelas as $val => $data)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $data[0]->rapot($val)->kelas }} {{ $data[0]->rapot($val)->tipe_kelas }}</td>
                      <td><a href="{{ route('rapor.show', Crypt::encrypt($val)) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-book"></i> &nbsp; Detail</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section('script')
  <script>
    $("#NilaiGuru").addClass("active");
    $("#liNilaiGuru").addClass("menu-open");
    $("#RapotGuru").addClass("active");
  </script>
@endsection
