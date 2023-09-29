@extends('layouts.soal')
@section('title', $siswa->nama_siswa)
@section('breadcrumb')
<h1>Nilai Laporan Ulangan </h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="{{ url('/elearning/laporan') }}">Nilai Laporan Ulangan</a></li>
	<li class="active">Detail</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Detail Jawaban Siswa</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-10 col-sm-8">
					<table style="background: #e6ebf2" class="table table-condensed table-bordered table-striped">
						<tr>
							<td>Nama siswa</td>
							<td>{{ $siswa->nama_siswa }}</td>
						</tr>
						<tr>
							<td>NIS</td>
							<td>{{ $siswa->nis }}</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>{{ $siswa->kelas->kelas}} {{ $siswa->kelas->tipe_kelas}}  </td>
						</tr>
						<tr>
							<td>Nilai</td>
							<td><b>{{ ($hasil_ujian->jumlah_nilai + $nilai_essay) }}</b></td>
						</tr>
					</table>

					@if($hasil_ujian->status == 0)
					<a target="_blank" href="{{ url('/cetak/pdf/hasil-ujian-persiswa/'.$siswa->id.'/'.$soal->id) }}" class="btn btn-warning btn-md" data-toggle='tooltip' title="Cetak laporan hasil ujian paket soal untuk siswa an. {{ $siswa->nama_siswa }}"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	@if($user->roles=="Admin")
	<div class="box box-danger">
		<div class="box-body">
			<p><i class="fa fa-question-circle" style="color: indianred"></i> Hasil kerja siswa dapat digunakan sebagai bahan evaluasi belajar siswa.</p>
			<p>Anda dapat mengelompokan jawaban siswa yang benar atau salah, sehingga memudahkan untuk mengidentifikasi materi apa yang sudah ataupun belum dikuasai oleh siswa.</p>
		</div>
	</div>
	@endif
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
@endpush
