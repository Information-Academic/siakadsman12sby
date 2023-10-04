@extends('template_backend.home')
@section('heading', 'Presensi Harian Siswa')
@section('page')
  <li class="breadcrumb-item active">Presensi Harian Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Absen</th>
                    <th>Jarak(Meter)</th>
                    <th>Status Oleh Sistem</th>
                    <th style="height: 10px;">Keterangan Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->created_at->isoFormat('D MMMM Y') }}</td>
                        <td>{{ number_format($data->distance) }}</td>
                        <td>
                            @if ($data->distance <= 10)
                                <span class="badge badge-success">Hadir</span>
                            @else
                                <span class="badge badge-danger">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>{{ $data->kehadiran->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Presensi Harian Siswa</h3>
      </div>
      <form action="{{route('presensisiswaharian.absen')}}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
              <label for="status_kehadiran">Keterangan Kehadiran</label>
              <select id="kehadirans_id" type="text" class="form-control @error('kehadirans_id') is-invalid @enderror select2bs4" name="kehadirans_id">
                <option value="">-- Pilih Keterangan Kehadiran --</option>
                @foreach ($kehadiran as $data)
                  <option value="{{ $data->id }}">{{ $data->keterangan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude:</label>
                <input type="text" name="latitude" id="latitude" readonly>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude:</label>
                <input type="text" name="longitude" id="longitude" readonly>
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
     <script>
        // Ambil geolocation pengguna
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        });
    </script>
@endsection
