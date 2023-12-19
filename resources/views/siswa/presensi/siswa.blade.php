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
                    <th>Status Oleh Sistem</th>
                    {{-- <th style="height: 10px;">Keterangan Kehadiran</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $data)
                    @if ($data->distance <= 2000)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->created_at->isoFormat('D MMMM Y') }}</td>
                        {{-- <td>{{ number_format($data->distance / 1000, 2, ',', '.') }}</td> --}}
                        <td>
                            @if ($data->distance <= 2000)
                                <span class="badge badge-success">Hadir</span>
                            {{-- @elseif($data->distance > 1000 && $data->distance <= 2000)
                                <span class="badge badge-warning">Terlambat</span>
                            @else
                                <span class="badge badge-danger">Tidak Hadir</span> --}}
                            @endif
                        </td>
                    </tr>
                    @endif
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
            <div>
                {{-- <div class="form-group">
                <label for="status_kehadiran">Keterangan Kehadiran</label>
                <select id="kehadirans_id" type="text" class="form-control @error('kehadirans_id') is-invalid @enderror select2bs4" name="kehadirans_id">
                    <option value="">-- Pilih Keterangan Kehadiran --</option>
                    @foreach ($kehadiran as $data)
                    <option value="{{ $data->id }}">{{ $data->keterangan }}</option>
                    @endforeach
                </select>
                </div> --}}
                <div class="form-group">
                    <input type="text" name="latitude" id="latitude" readonly hidden>
                </div>
                <div class="form-group">
                    <input type="text" name="longitude" id="longitude" readonly hidden>
                </div>
                <div class="form-group">
                    <label for="">Apabila ingin membuat surat permohonan maka tidak perlu presensi hari ini!</label>
                </div>
                <div class="form-group">
                    <a href="{{route('siswa.suratpermohonan')}}"> Ajukan untuk membuat surat izin / sakit </a>
                </div>
            </div>
            <iframe
                id="iframe-map"
                style="border:0; width: 100%; height: 500px"
                loading="lazy"
                allowfullscreen>
            </iframe>
        </div>
        <div class="card-footer">
            <p id="teks-lokasi">Sedang mendapatkan lokasi Anda...</p>
            <button name="submit" class="btn btn-primary" id="presensi">
                <i class="nav-icon fas fa-save"></i>
                &nbsp;
                <span id="teks-btn-presensi">Presensi Sekarang</span>
            </button>
        </div>
      </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#AbsenSiswa").addClass("active");
    </script>
     <script>
        // Ambil geolocation pengguna
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            $('#iframe-map').attr('src',
                "https://www.google.com/maps/embed/v1/place?q=" + lat + "%2C%20" + lng +
                "&key=AIzaSyB0YeB03qphqQUGpbOn2vnjLrpTOUsLHbU"
            )

            $.ajax({
                method: 'GET',
                url: '{{route("presensiValidSiswa")}}',
                data: { latitude: lat, longitude: lng },
                success: function(data){
                    if (data.valid == false) {
                        $("#teks-lokasi").text("Jarak Anda Sekarang (" + data.distance + " KM) melebihi batas presensi 2 meter")
                        // $('#teks-btn-presensi').text("Presensi Sekarang (Tidak Hadir)")
                        $('#presensi').hide()
                    } else {
                        $("#teks-lokasi").text("Jarak Anda Sekarang " + data.distance + " M")
                        $('#teks-btn-presensi').text("Presensi Sekarang (Hadir)")
                        $('#presensi').attr('disabled', false)
                    }
                }
            });
        }, null, { enableHighAccuracy: true });
    </script>
@endsection
