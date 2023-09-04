@extends('layouts.soal')
@section('title', 'Ubah Data Soal')
@section('breadcrumb')
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/soal') }}">Soal</a></li>
    <li class="active">Ubah data soal</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Ubah Data Soal</h3>
    </div>
    <form class="form-horizontal" id="formSoal" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$soal->id}}">
      <div class="box-body">
        <div class="form-group">
          <label for="tipe_ulangan" class="col-sm-2 control-label">Tipe Ulangan</label>
          <div class="col-sm-10">
            <select name="tipe_ulangan" class="form-control">
            	<option value="{{ $soal->tipe_ulangan }}">{{ getJenisSoal($soal->tipe_ulangan) }}</option>
            	<option value="UH">Ulangan Harian</option>
            	<option value="UTS">Ulangan Tengah Semester</option>
              <option value="UAS">Ulangan Akhir Semester</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="mapel" class="col-sm-2 control-label">Materi</label>
          <div class="col-sm-10">
            <select name="mapels_id" class="form-control">
              @foreach ($mapels as $mapel)
            	<option value="{{ $mapel->id }}">{{$mapel->nama_mapel}}</option>
              @endforeach
            </select>    
          </div>
        </div>

        <div class="form-group">
          <label for="waktu" class="col-sm-2 control-label">Waktu</label>
          <div class="col-sm-2">
            <input type="text" class="form-control numOnly" data-toggle="tooltip" title="Masukan waktu ujian dalam satuan menit" name="waktu" placeholder="Waktu" value="{{ $soal->waktu }}">
          </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-offset-2 col-sm-10">
        		<div id="wrap-btn">
	        		<button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
			        <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
			      </div>
            <div id="notif" style="display: none; margin-top: 15px""></div>
        	</div>
        </div>
        <div class="overlay" id="loading" style="display: none;"><i class="fa fa-refresh fa-spin" ></i></div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('css')
<style type="text/css">
  .panel {
    margin-bottom: 5px !important;
  }
  .form-group {
    margin-bottom: 5px;
  }
</style>
@endpush
@push('scripts')
<script>
$(document).ready(function(){
	$("#btnSimpan").click(function(){
		$("#wrap-btn").hide();
    $("#loading").show();
    var dataString = $("#formSoal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-soal') }}",
      data: dataString,
      success: function(data){
        console.log(data);
        if (data == 'ok') {
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("<i class='fa fa-info-circle'></i> Data berhasil disimpan.").fadeIn(350);
          window.location.href = "{{ url('/soal/detail/'.$soal->id) }}";
        }else{
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).fadeIn(350);
        }
      }
    })
	});
});
</script>
@endpush