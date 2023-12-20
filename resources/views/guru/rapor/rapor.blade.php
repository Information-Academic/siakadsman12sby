@extends('template_backend.home')
@section('heading', 'Data Nilai Rapor')
@section('page')
  <li class="breadcrumb-item active">Data Nilai Rapor</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Data Nilai Rapor</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->kelas }} {{ $kelas->tipe_kelas }} </td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->count() }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel }}</td>
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
                            <th class="ctr" rowspan="2">No.</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th rowspan="2">NIS</th>
                            <th class="ctr" colspan="4">Nilai Rapor</th>
                        </tr>
                        <tr>
                            <th class="ctr" >KKM Nilai</th>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Catatan Wali Kelas</th>
                            <th class="ctr">Kesimpulan</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($siswa as $val => $data)
                                <tr>
                                    <td class="ctr">{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_siswa }}</td>
                                    <td>{{$data->nis}}</td>
                                    <td class="ctr">
                                        <div class="text-center">75</div>
                                    </td>
                                    @if ($data->nilai($data->id))
                                        <td class="ctr">
                                            <div class="text-center">{{ round($data->nilai($data->id)->nilai_rapor,2) }}</div>
                                        </td>
                                        <td class="ctr">
                                            @if ( $data->nilai($data->id)->nilai_rapor > 88)
                                                <div class="text-center">A (Sangat Baik)</div>
                                            @elseif ( $data->nilai($data->id)->nilai_rapor > 79 && $data->nilai($data->id)->nilai_rapor <=88)
                                                <div class="text-center">B (Baik)</div>
                                            @elseif ( $data->nilai($data->id)->nilai_rapor > 70 && $data->nilai($data->id)->nilai_rapor <=79)
                                                <div class="text-center">C (Cukup)</div>
                                            @else
                                                <div class="text-center">D (Kurang)</div>
                                            @endif
                                        </td>
                                        @if ($data->nilai($data->id)->catatan)
                                            <td class="ctr">
                                                <div class="text-center">{{ ucfirst($data->nilai($data->id)->catatan) }}
                                                    <button type="submit" id="submit-{{$data->id}}" class="btn btn-primary btn-sm btn-edit" data-id="{{$data->id}}"><i class="nav-icon fas fa-save"></i> &nbsp; Edit</button>
                                                </div>
                                            </td>
                                        @else
                                        <td>
                                            @csrf
                                            <input name="catatan" id="catatan" placeholder="Masukkan catatan wali kelas"></input>
                                            <button type="submit" id="submit-{{$data->id}}" class="btn btn-primary btn-sm btn-click" data-id="{{$data->id}}"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
                                        </td>
                                        @endif
                                        @if($data->nilai($data->id)->kesimpulan)
                                        <td class="ctr">
                                            <div class="text-center">{{ ucfirst($data->nilai($data->id)->kesimpulan) }}
                                                <button type="submit" id="submit-{{$data->id}}" class="btn btn-primary btn-sm btn-kesimpulan-edit " data-id="{{$data->id}}"><i class="nav-icon fas fa-save"></i> &nbsp; Edit Kesimpulan</button>
                                            </div>
                                        </td>
                                        @else
                                        <td>
                                            @csrf
                                            <input name="kesimpulan" id="kesimpulan" placeholder="Masukkan kesimpulan"></input>
                                            <button type="submit" id="submit-{{$data->id}}" class="btn btn-primary btn-sm btn-kesimpulan" data-id="{{$data->id}}"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Data</button>
                                        </td>
                                        @endif
                                    @endif
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
        $(".btn-click").click(function(){
            var id = $(this).attr('data-id');
            var catatan = $("input[name=catatan]").val();
            if (catatan == "") {
                toastr.error("Catatan tidak boleh ada yang kosong!");
            }
             else {
                $.ajax({
                    url: "{{ route('rapor.catatan') }}",
                    type: "POST",
                    dataType: 'json',
                    data : {
                        _token: '{{ csrf_token() }}',
                        siswas_id : id,
                        catatan: catatan
                    },
                    success: function(data){
                        toastr.success("Catatan siswa berhasil ditambahkan!");
                        window.location.reload();
                    },
                    error: function (data) {
                        toastr.warning("Errors 404!");
                    }
                });
            }
        });

        $(".btn-kesimpulan").click(function(){
            var id = $(this).attr('data-id');
            var kesimpulan = $("input[name=kesimpulan]").val();
            if (kesimpulan == "") {
                toastr.error("Kesimpulan tidak boleh ada yang kosong!");
            }
             else {
                $.ajax({
                    url: "{{ route('rapor.kesimpulan') }}",
                    type: "POST",
                    dataType: 'json',
                    data : {
                        _token: '{{ csrf_token() }}',
                        siswas_id : id,
                        kesimpulan: kesimpulan
                    },
                    success: function(data){
                        toastr.success("Kesimpulan siswa berhasil ditambahkan!");
                        window.location.reload();
                    },
                    error: function (data) {
                        toastr.warning("Errors 404!");
                    }
                });
            }
        });

        $(".btn-edit").click(function(){
            var id = $(this).attr('data-id');
            var catatan = $("input[name=catatan]").val();
            if (catatan == "") {
                toastr.error("Catatan tidak boleh ada yang kosong!");
            }
             else {
                $.ajax({
                    url: "{{ route('rapor.catatan') }}",
                    type: "POST",
                    dataType: 'json',
                    data : {
                        _token: '{{ csrf_token() }}',
                        siswas_id : id,
                        catatan: catatan
                    },
                    success: function(data){
                        toastr.warning("Editing in process!");
                        window.location.reload();
                    },
                    error: function (data) {
                        toastr.warning("Errors 404!");
                    }
                });
            }
        });

        $(".btn-kesimpulan-edit").click(function(){
            var id = $(this).attr('data-id');
            var kesimpulan = $("input[name=kesimpulan]").val();
            if (kesimpulan == "") {
                toastr.error("Kesimpulan tidak boleh ada yang kosong!");
            }
             else {
                $.ajax({
                    url: "{{ route('rapor.kesimpulan') }}",
                    type: "POST",
                    dataType: 'json',
                    data : {
                        _token: '{{ csrf_token() }}',
                        siswas_id : id,
                        kesimpulan: kesimpulan
                    },
                    success: function(data){
                        toastr.warning("Editing Kesimpulan in process!");
                        window.location.reload();
                    },
                    error: function (data) {
                        toastr.warning("Errors 404!");
                    }
                });
            }
        });

        $("#NilaiGuru").addClass("active");
        $("#liNilaiGuru").addClass("menu-open");
        $("#RapotGuru").addClass("active");
    </script>
@endsection
