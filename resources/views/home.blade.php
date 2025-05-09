@extends('template_backend.home')
@section('heading', 'Dashboard')
@section('page')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
    <div class="col-md-12" id="load_content">
      <div class="card card-primary">
        <div class="card-body">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Jam Pelajaran</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Tipe Kelas</th>
                  </tr>
                </thead>
                <tbody id="data-jadwal">
                    @php
                      $hari = date('w');
                      $jam = date('H:i');
                    @endphp
                    @if ( $jadwal->count() > 0 )
                      @if (
                        $hari == '1' && $jam >= '09:30' && $jam <= '10:00' ||
                        $hari == '2' && $jam >= '09:30' && $jam <= '10:00' ||
                        $hari == '3' && $jam >= '09:30' && $jam <= '10:00' ||
                        $hari == '4' && $jam >= '09:30' && $jam <= '10:00' ||
                        $hari == '5' && $jam >= '09:30' && $jam <= '10:00'
                      )
                      <tr>
                        <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat Pertama!</td>
                      </tr>
                      @elseif(
                        $hari == '1' && $jam >= '11:30' && $jam <= '12:15' ||
                        $hari == '2' && $jam >= '11:30' && $jam <= '12:15' ||
                        $hari == '3' && $jam >= '11:30' && $jam <= '12:15' ||
                        $hari == '4' && $jam >= '11:30' && $jam <= '12:15' ||
                        $hari == '5' && $jam >= '11:30' && $jam <= '12:15'
                      )
                      <tr>
                        <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat Kedua!</td>
                      </tr>
                      @else
                      @foreach ($jadwal as $data)
                        <tr>
                          <td>{{ $data->jam_mulai.' - '.$data->jam_selesai }}</td>
                          <td>
                              <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                              <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                          </td>
                          <td>{{ $data->kelas->kelas}}</td>
                          <td>{{ $data->kelas->tipe_kelas}}</td>
                        </tr>
                      @endforeach
                  @endif
                  @elseif ($jam <= '06:30')
                    <tr>
                      <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Akan Segera Dimulai!</td>
                    </tr>
                  @elseif (
                  $hari == '1' && $jam >= '15:15' ||
                  $hari == '2' && $jam >= '15:15' ||
                  $hari == '3' && $jam >= '15:15' ||
                  $hari == '4' && $jam >= '15:15' ||
                  $hari == '5' && $jam >= '14:00'
                  )
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Sudah Selesai!</td>
                  </tr>
                @elseif ($hari == '0' || $hari == '6')
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Sekalah Libur!</td>
                  </tr>
                @elseif($hari == '1' && $jam >= '06:30' && $jam <= '07:15')
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Upacara Bendera!</td>
                  </tr>
                @else
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Tidak Ada Data Jadwal!</td>
                  </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card card-warning" style="width: 980px; height: 900px;">
        <div class="card-header">
          <h3 class="card-title" style="color: white;">
            Pengumuman
          </h3>
        </div>
        <div class="card-body">
            <div class="tab-content p-0" style="font-weight: bold; text-align: center;">
                {!! $pengumuman['judul_pengumuman'] !!}
            </div>
            <div class="tab-content p-0">
            {!! $pengumuman['isi_pengumuman'] !!}
            </div>
          <br>
        </div>
      </div>
    </div>
@endsection
@section('script')
    <script>
      $(document).ready(function () {
        setInterval(function() {
          var date = new Date();
          var hari = date.getDay();
          var h = date.getHours();
          var m = date.getMinutes();
          h = (h < 10) ? "0" + h : h;
          m = (m < 10) ? "0" + m : m;
          var jam = h + ":" + m;

          if (hari == '0' || hari == '6') {
            $("#data-jadwal").html(
              `<tr>
                <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Sekalah Libur!</td>
              </tr>`
            );
          } else {
            if (jam <= '06:30') {
              $("#data-jadwal").html(
                `<tr>
                  <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Akan Segera Dimulai!</td>
                </tr>`
              );
            } else if (
              hari == '1' && jam >= '15:15' ||
              hari == '2' && jam >= '15:15' ||
              hari == '3' && jam >= '15:15' ||
              hari == '4' && jam >= '15:15' ||
              hari == '5' && jam >= '14:00'
            ) {
              $("#data-jadwal").html(
                `<tr>
                  <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Sudah Selesai!</td>
                </tr>`
              );
            } else {
              if (
                hari == '1' && jam >= '09:30' && jam <= '10:00' ||
                hari == '2' && jam >= '09:30' && jam <= '10:00' ||
                hari == '3' && jam >= '09:30' && jam <= '10:00' ||
                hari == '4' && jam >= '09:30' && jam <= '10:00' ||
                hari == '5' && jam >= '09:30' && jam <= '10:00'
              ) {
                $("#data-jadwal").html(
                  `<tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat Pertama!</td>
                  </tr>`
                );
              }
              else if (
                hari == '1' && jam >= '11:30' && jam <= '12:15' ||
                hari == '2' && jam >= '11:30' && jam <= '12:15' ||
                hari == '3' && jam >= '11:30' && jam <= '12:15' ||
                hari == '4' && jam >= '11:30' && jam <= '12:15' ||
                hari == '5' && jam >= '11:30' && jam <= '12:15'
              ) {
                $("#data-jadwal").html(
                  `<tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat Kedua!</td>
                  </tr>`
                );
              }
              else if (hari == '1' && jam >= '06:30' && jam <= '07:15') {
                $("#data-jadwal").html(
                  `<tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Upacara Bendera!</td>
                  </tr>`
                );
              } else {
                $.ajax({
                  type:"get",
                  data: {
                    hari : hari,
                    jam : jam
                  },
                  dataType:"json",
                  url:"{{ url('/jadwal/sekarang') }}",
                  success:function(data){
                    var html = "";
                    $.each(data, function (index, val) {
                        html += "<tr>";
                          html += "<td>" + val.jam_mulai + ' - ' + val.jam_selesai + "</td>";
                          html += "<td><h5 class='card-title'>" + val.mapel + "</h5><p class='card-text'><small class='text-muted'>" + val.guru + "</small></p></td>";
                          html += "<td>" + val.kelas + "</td>";
                          html += "<td>" + val.tipe_kelas + "</td>";
                        html += "</tr>";
                    });
                    $("#data-jadwal").html(html);
                  }
                });
              }
            }
          }
        }, 60 * 1);
      });

      $("#Dashboard").addClass("active");
      $("#liDashboard").addClass("menu-open");
      $("#Home").addClass("active");
    </script>
@endsection
