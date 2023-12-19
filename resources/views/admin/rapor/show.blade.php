@extends('template_backend.home')
@section('heading', 'Show Rapot')
@section('page')
  <li class="breadcrumb-item active">Show Rapor</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Show Rapor</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>No Induk Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->kelas }}</td>
                    </tr>
                    <tr>
                        <td>Tipe Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->tipe_kelas }}</td>
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
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="ctr" rowspan="3">No.</th>
                            <th class="ctr" rowspan="3">Mata Pelajaran</th>
                        </tr>
                        <tr>
                            <th class="ctr">KKM</th>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            {{-- <th class="ctr">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($mapel as $val => $data)
                                <?php $data = $data[0]; ?>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->mapel->nama_mapel }}</td>
                                    @php
                                        $array = array('mapel' => $val, 'siswa' => $siswa->id);
                                        $jsonData = json_encode($array);
                                    @endphp
                                    <td class="ctr">75</td>
                                    <td class="ctr">{{ round($data->cekRapot($jsonData)['nilai_rapor'] ,2) }}</td>
                                    <td class="ctr">
                                        @if ( $data->cekRapot($jsonData)['nilai_rapor ']> 88)
                                        <div class="text-center">A (Sangat Baik)</div>
                                        @elseif ( $data->cekRapot($jsonData)['nilai_rapor'] > 79 && $data->cekRapot($jsonData)['nilai_rapor'] <=88)
                                        <div class="text-center">B (Baik)</div>
                                        @elseif ( $data->cekRapot($jsonData)['nilai_rapor'] > 70 && $data->cekRapot($jsonData)['nilai_rapor'] <=79)
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
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')
    <script>
        $("#Nilai").addClass("active");
        $("#liNilai").addClass("menu-open");
        $("#Rapot").addClass("active");
    </script>
@endsection
