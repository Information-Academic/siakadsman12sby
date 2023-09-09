@extends('template_backend.home')
@section('heading', 'Data Kelas')
@section('page')
  <li class="breadcrumb-item active">Data Kelas</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-primary btn-sm" onclick="getCreateKelas()" data-toggle="modal" data-target="#form-kelas">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Kelas
              </button>
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kelas</th>
                    <th>Tipe Kelas</th>
                    <th>Tahun</th>
                    <th>Wali Kelas</th>
                    <th>Status Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->kelas }}</td>
                    <td>{{ $data->tipe_kelas }}</td>
                    <td>{{ $data->tahun }}</td>
                    <td>{{ $data->guru['nama_guru'] }}</td>
                    <td>{{$data->status_kelas}}</td>
                    <td>
                        <form action="{{ route('kelas.destroy', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-info btn-xs" onclick="getSubsSiswa({{$data->id}})" data-toggle="modal" data-target=".view-siswa">
                              <i class="nav-icon fas fa-users"></i> &nbsp; View Siswa
                            </button>
                            <button type="button" class="btn btn-info btn-xs" onclick="getSubsJadwal({{$data->id}})" data-toggle="modal" data-target=".view-jadwal">
                              <i class="nav-icon fas fa-calendar-alt"></i> &nbsp; View Jadwal
                            </button>
                            <button type="button" class="btn btn-success btn-xs" onclick="getEditKelas({{$data->id}})" data-toggle="modal" data-target="#form-kelas">
                              <i class="nav-icon fas fa-edit"></i> &nbsp; Edit
                            </button>
                            <a href="{{route('kelas.edit',Crypt::encrypt($data->id))}}" class="btn btn-success btn-xs">
                            <i class="nav-icon fas fa-edit"></i>Edit Status Kelas</a>
                            <button class="btn btn-danger btn-xs"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                    </td>
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

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md" id="form-kelas" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('kelas.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <div class="form-group" id="form_nama"></div>
              <div class="form-group">
                <label for="guru_id">Wali Kelas</label>
                <select id="gurus_id" name="gurus_id" class="select2bs4 form-control @error('gurus_id') is-invalid @enderror">
                  <option value="">-- Pilih Wali Kelas --</option>
                  @foreach ($guru as $data)
                    <option value="{{ $data->id }}">{{ $data->nama_guru }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg view-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul-siswa">View Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" width="100%">
                <thead>
                  <tr>
                    <th>No Induk Siswa</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Foto Siswa</th>
                    <th>Status Siswa</th>
                  </tr>
                </thead>
                <tbody id="data-siswa">
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</button>
          <a id="link-siswa" href="#" class="btn btn-primary"><i class="nav-icon fas fa-download"></i> &nbsp; Download PDF</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-xl view-jadwal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="judul-jadwal">View Jadwal</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card-body">
            <table class="table table-bordered table-striped table-hover" width="100%">
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Jadwal</th>
                  <th>Jam Pelajaran</th>
                </tr>
              </thead>
              <tbody id="data-jadwal">
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</button>
        <a id="link-jadwal" href="#" class="btn btn-primary"><i class="nav-icon fas fa-download"></i> &nbsp; Download PDF</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script>
    function getCreateKelas(){
      $("#judul").text('Tambah Data Kelas');
      $('#id').val('');
      $('#form_nama').html(`
        <label for="kelas">Kelas</label>
        <input type='text' id="kelas" onkeyup="this.value = this.value.toUpperCase()" name='kelas' class="form-control @error('kelas') is-invalid @enderror" placeholder="{{ __('Kelas') }}">
        <label for="tipe_kelas">Tipe Kelas</label>
        <input type='text' id="tipe_kelas" onkeyup="this.value = this.value.toUpperCase()" name='tipe_kelas' class="form-control @error('tipe_kelas') is-invalid @enderror" placeholder="{{ __('Tipe Kelas') }}">
        <label for="tahun">Tahun</label>
        <input type='text' id="tahun" onkeyup="this.value = this.value.toUpperCase()" name='tahun' class="form-control @error('tahun') is-invalid @enderror" placeholder="{{ __('Tahun') }}">
        <label for="tahun">Status Kelas</label>
        <select id="status_kelas" name="status_kelas" class="select2bs4 form-control @error('status_kelas') is-invalid @enderror">
            <option value="">-- Pilih Status Kelas --</option>
            <option value="Aktif">Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
      `);
      $('#kelas').val('');
      $('#gurus_id').val('');
    }

    function getEditKelas(id){
      var parent = id;
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/kelas/edit/json') }}",
        success:function(result){
          if(result){
            $.each(result,function(index, val){
              $("#judul").text('Edit Data Kelas ' + val.kelas + ' ' + val.tipe_kelas);
              $('#id').val(val.id);
              $('#form_nama').html('');
              $('#kelas').val(val.kelas);
              $('#tipe_kelas').val(val.tipe_kelas);
              $('#tahun').val(val.tahun);
              $('#gurus_id').val(val.gurus_id);
            });
          }
        },
        error:function(){
          toastr.error("Errors 404!");
        },
        complete:function(){
        }
      });
    }

    function getSubsSiswa(id){
      var parent = id;
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/siswa/view/json') }}",
        success:function(result){
          var siswa = "";
          if(result){
            $.each(result,function(index, val){
              $("#judul-siswa").text('View Data Siswa ' + val.kelas);
              siswa += "<tr>";
                siswa += "<td>"+val.nis+"</td>";
                siswa += "<td>"+val.nama_siswa+"</td>";
                siswa += "<td>"+val.jenis_kelamin+"</td>";
                siswa += "<td>"+val.alamat+"</td>";
                siswa += "<td>"+val.tempat_lahir+"</td>";
                siswa += "<td>"+val.tanggal_lahir+"</td>";
                siswa += "<td><img src='"+val.foto_siswa+"' width='100px'></td>";
                siswa += "<td>"+val.status_siswa+"</td>";
              siswa+="</tr>";
            });
            $("#data-siswa").html(siswa);
          }
        },
        error:function(){
          toastr.error("Errors 404!");
        }
      });
      $("#link-siswa").attr("href","http://127.0.0.1:8000/siswa-pdf/" +id);
    }

    function getSubsJadwal(id){
      var parent = id;
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/jadwal/view/json') }}",
        success:function(result){
          // console.log(result);
          var jadwal = "";
          if(result){
            $.each(result,function(index, val){
              $("#judul-jadwal").text('View Data Jadwal ' + val.kelas + ' ' + val.tipe_kelas);
              jadwal += "<tr>";
                jadwal += "<td>"+val.hari+"</td>";
                jadwal += "<td><h5 class='card-title'>"+val.nama_mapel+"</h5><p class='card-text'><small class='text-muted'>"+val.nama_guru+"</small></p></td>";
                jadwal += "<td>"+val.jam_mulai+" - "+val.jam_selesai+"</td>";
              jadwal+="</tr>";
            });
            $("#data-jadwal").html(jadwal);
          }
        },
        error:function(){
          toastr.error("Errors 404!");
        },
        complete:function(){
        }
      });
      $("#link-jadwal").attr("href", "https://siakad.didev.id/jadwalkelaspdf/"+id);
    }

    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataKelas").addClass("active");
  </script>
@endsection
