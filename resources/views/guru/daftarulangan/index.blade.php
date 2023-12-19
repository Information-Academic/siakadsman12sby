@extends('layouts.soal')
@section('title', 'Data siswa')
@section('breadcrumb')
<h1>Master Data</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
  <li class="active">Siswa</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Siswa</h3>
    </div>
    <div class="box-body">
      @if(Auth::user()->roles == "Siswa")
      <div class="well" style="display: none;" id="wrap-siswa">
        <form class="form-horizontal" id="form-siswa">
          <div class="box-body">
            <div class="form-group">
              <label for="nama_siswa" class="col-sm-3 control-label">Nama Siswa</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" placeholder="Nama">
              </div>
            </div>
            <div class="form-group">
              <label for="nis" class="col-sm-3 control-label">NIS</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nis" name="nis" placeholder="NIS">
              </div>
            </div>
          </div>
        </form>
        <hr>
      </div>
      @endif
      <table id="tabel_siswa" class="table table-hover table-condensed">
        <thead>
          <tr>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>NIS</th>
            <th style="width: 130px; text-align: center;">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
<style type="text/css">
  .select2-container--default .select2-selection--single {
    height: 33px;
  }

  .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }

  .inputfile+label {
    font-size: 1.25em;
    font-weight: 700;
    color: white;
    background-color: green;
    display: inline-block;
    padding: 10px;
  }

  .inputfile:focus+label,
  .inputfile+label:hover {
    background-color: darkgreen;
  }

  .inputfile+label {
    cursor: pointer;
  }

  .inputfile:focus+label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
  }

  .inputfile+label * {
    pointer-events: none;
  }
</style>
@endpush
@push('scripts')
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
  $(document).ready(function() {
    $('.select2Class').select2();

    tabel_siswa = $('#tabel_siswa').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: '{{ route("guru.data_siswa") }}',
      columns: [{
          data: 'nama_depan',
          name: 'nama_depan',
          orderable: true,
          searchable: true
        },
        {
          data: 'nama_belakang',
          name: 'nama_belakang',
          orderable: true,
          searchable: true
        },
        {
          data: 'nis',
          name: 'nis',
          orderable: true,
          searchable: true
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ],
    });

    $("#btn-siswa").click(function() {
      $("#wrap-siswa").slideToggle();
    });

    $("#batal").click(function() {
      $("#wrap-siswa").slideToggle();
    });
  });
</script>
@endpush
