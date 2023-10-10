@extends('template_backend.home')
@section('heading', 'Nilai Rapor')
@section('page')
  <li class="breadcrumb-item active">Nilai Rapor</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Nilai Rapor Siswa</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>No Induk Siswa</td>
                        <td>:</td>
                        <td>{{ Auth::user()->nis }}</td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td>:</td>
                        <td class="text-capitalize">{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}</td>
                    </tr>
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->kelas }} {{ $kelas->tipe_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->guru->nama_guru }}</td>
                    </tr>
                    @php
                        $bulan = date('m');
                        $tahun = date('Y');
                    @endphp
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ 'Semester Ganjil' }}
                            @else
                                {{ 'Semester Genap' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ $tahun }}/{{ $tahun+1 }}
                            @else
                                {{ $tahun-1 }}/{{ $tahun }}
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h4 class="mb-3">Nilai Rapor {{Auth::user()->nama_depan}} {{Auth::user()->nama_belakang}}</h4>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Mata Pelajaran</th>
                                    <th rowspan="2">KKM</th>
                                    <th rowspan="2">Nilai</th>
                                    <th rowspan="2">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapel as $val => $data)
                                    <tr>
                                        <?php $data = $data[0]; ?>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->mapel->nama_mapel }}</td>
                                        <td class="ctr">75</td>
                                        <td class="ctr">{{ $data->nilai($val)['nilai_rapor'] }}</td>
                                        <td class="ctr">
                                            @if ( $data->nilai($data->id)['nilai_rapor ']> 88)
                                                <div class="text-center">A (Sangat Baik)</div>
                                            @elseif ( $data->nilai($data->id)['nilai_rapor'] > 79 && $data->nilai($data->id)['nilai_rapor'] <=88)
                                                <div class="text-center">B (Baik)</div>
                                            @elseif ( $data->nilai($data->id)['nilai_rapor'] > 70 && $data->nilai($data->id)['nilai_rapor'] <=79)
                                                <div class="text-center">C (Cukup)</div>
                                            @else
                                                <div class="text-center">D (Kurang)</div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')
    <script>
        $("#RapotSiswa").addClass("active");
    </script>
@endsection
