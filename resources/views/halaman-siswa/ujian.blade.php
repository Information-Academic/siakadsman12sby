@extends('layouts.soal')
@section('title', 'Rolas Xam - '.Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang)
@section('breadcrumb')
  <h1><i class="fa fa-check-square"></i> Soal Ujian</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Hi, {{ Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang }}</li>
  </ol>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Soal yang bisa dikerjakan sekarang.</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
		    <div class="row">
		    	@if($distribusi->count())
			    	@foreach($distribusi as $paket_soal)
			    		<?php
			    			$check = App\Jawaban::where('ulangans_id', $paket_soal->ulangans_id)->first();
			    		?>
				    	<div class="col-sm-4">
				    		@if($check)
			    				<a href="{{ url('ujian/finish/'.$paket_soal->ulangans_id) }}">
						    		<div class="info-box bg-yellow">
					            <span class="info-box-icon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
					            <div class="info-box-content">
					              <span class="info-box-text" style="width: 100%;">{{ $paket_soal->soal->tipe_ulangan }}  {{ $paket_soal->soal->mapel->nama_mapel }}</span>
					              <div class="progress">
					                <div class="progress-bar" style="width: 100%"></div>
					              </div>
                                  <span class="progress-description">Kelas {{$kelas['0']['kelas']}} {{$kelas['2']['tipe_kelas']}}</span>
				                <span class="progress-description">Waktu Pengerjaan: {{ $paket_soal->soal->waktu }} menit</span>
				                <span>Kamu sudah menyelesaikan ujian ini.</span>
					            </div>
					          </div>
						    	</a>
				    		@else
				    			<a href="{{ url('ujian/detail/'.$paket_soal->ulangans_id) }}">
						    		<div class="info-box bg-green">
					            <span class="info-box-icon"><i class="fa fa-check-square-o"></i></span>
					            <div class="info-box-content">
					              <span class="info-box-text">{{ $paket_soal->soal->tipe_ulangan }} {{ $paket_soal->soal->mapel->nama_mapel }} </span>
					              <div class="progress">
					                <div class="progress-bar" style="width: 100%"></div>
					              </div>
                                  <span class="progress-description">Kelas {{$kelas['3']['kelas']}} {{$kelas['0']['tipe_kelas']}}</span>
				                <span class="progress-description">Waktu Pengerjaan: {{ $paket_soal->soal->waktu }} menit</span>
					            </div>
					          </div>
						    	</a>
			    			@endif
				    	</div>
			    	@endforeach
		    	@else
						<div class="col-md-12">Belum ada soal yang bisa dikerjakan.</div>
		    	@endif
		    </div>
	    </div>
    </div>
  </div>
@endsection
@push('css')
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}
</style>
@endpush
