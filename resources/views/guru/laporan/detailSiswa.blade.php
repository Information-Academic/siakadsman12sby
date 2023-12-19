@extends('layouts.soal')
@section('title', $siswa->nama_depan.' '.$siswa->nama_belakang)
@section('breadcrumb')
<h1>Laporan</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="{{ url('/elearning/laporan') }}">Laporan</a></li>
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
							<td>{{ $siswa->nama_depan }} {{$siswa->nama_belakang}}</td>
						</tr>
						<tr>
							<td>NIS</td>
							<td>{{ $siswa->nis }}</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>{{ $siswa2->kelas->kelas }} {{$siswa2->kelas->tipe_kelas}}</td>
						</tr>
						<tr>
							<td>Paket soal</td>
							<td>{{ $soal->tipe_ulangan }} {{$soal->mapel->nama_mapel}}</td>
						</tr>
						<tr>
							<td>Waktu ujian</td>
							<td>{{ timeStampIndo($hasil_ujian['created_at']) }}</td>
						</tr>
						<tr>
							<td>Status ujian</td>
							<td>
								@if($hasil_ujian->status == 1)
								<label class="label label-info">Selesai</label>
								@else
								<label class="label label-warning">Sedang berlangsung</label>
								@endif
							</td>
						</tr>
					</table>
				</div>
			</div>
			<hr>
			<h4>Soal Pilihan Ganda</h4>
			<hr style="margin: 4px 0 5px">
			<table id="table_hasil_ujian" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Soal</th>
						<th>Kunci</th>
						<th>Jawaban</th>
						<th>Nilai</th>
					</tr>
				</thead>
			</table>

			<hr>
			<h4>Soal Essay</h4>
			<hr style="margin: 4px 0 5px">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th style="width: 10px"></th>
						<th style="width: 50%">Soal</th>
						<th>Jawaban</th>
						<th class="text-center" style="width: 90px">Nilai</th>
					</tr>
				</thead>
				<tbody>
					@if($soal_essay->count())
					<?php $no = 1; ?>
					@foreach($soal_essay as $essay)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{!! $essay->soal ?? '' !!}</td>
						<td>{!! $essay->getJawab->jawab ?? '' !!}</td>
						<td>
							<input type="number" class="form-control numOnly nilai-essay" data-kelas="{{$essay->kelas_id}}" data-ulangan="{{$essay->ulangans_id}}" data-id="{{ $essay->id ?? 0 }}" data-user="{{ $essay->getJawab->users_id ?? 0 }}" value="{{ $essay->getJawab->nilai ?? '' }}" placeholder="Nilai" min="20" max="100">
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4">
	@if($user->roles == 'Guru')
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
<script>
	function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this,
				args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function() {
				callback.apply(context, args);
			}, ms || 0);
		};
	}

	$(document).ready(function() {
		table_hasil_ujian = $('#table_hasil_ujian').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			lengthChange: true,

			ajax: {
				url: "{!! route('guru.hasilSiswa') !!}",
				data: {
					"id_user": '{{ $siswa->id }}',
                    "id_ulangan": '{{ $hasil_ujian->ulangans_id }}',
				},
			},
			columns: [
				{
					data: 'soal',
					name: 'soal',
					orderable: true,
					searchable: true
				},
				{
					data: 'kunci',
					name: 'kunci',
					orderable: true,
					searchable: true,
				},
				{
					data: 'pilihan',
					name: 'pilihan',
					orderable: true,
					searchable: true,
				},
				{
					data: 'nilai',
					name: 'nilai',
					orderable: true,
					searchable: true,
				},
			],
		});

		$(document).on('keyup', '.nilai-essay', delay(function() {
            const ulangan_id = $(this).data('ulangan');
			const essay_id = $(this).data('id');
			const user_id = {{ $siswa->id }};
			const siswa_id = {{ $siswa2->id }};
            const kelas_id = {{ $siswa2->kelas->id }};
			const mapel_id = {{ $soal->mapel->id }};
			const nilai = $(this).val();
			$.ajax({
				type: "GET",
				url: "{{ route('guru.simpan-score' ) }}",
				data: {
                    ulangan_id: ulangan_id,
					essay_id: essay_id,
					user_id: user_id,
					siswa_id: siswa_id,
                    kelas_id: kelas_id,
					mapel_id: mapel_id,
					nilai: nilai
				},
				success: function(data) {
					console.log(data);
				}
			})
		}, 500));
	});
</script>
@endpush
