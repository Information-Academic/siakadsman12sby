<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	input[type="radio"] {
		margin-top: 3px;
	}
	table {
		border-collapse: collapse;
	}
	.garis {
		border: solid thin #333;
		padding: 6px;
	}
	.well {
		background: #f2f6fc;
		padding: 15px;
		border: solid thin #d7dee8;
		color: #3a4149;
	}
	.benar {
		background: #e5f9e9;
		color: #1d231e;
		padding: 10px 15px 0 15px;
	}
	.salah {
		background: #f9f1ed;
		color: #1d231e;
	}
</style>
<title>Hasil Ujian {{ $siswa->nama_siswa }}</title>
<?php require app_path().'/functions/myconf.php'; ?>
<table width="100%">
	<tr>
		<td style="width: 75px">Nama</td>
		<td style="width: 15px">:</td>
		<td>{{ $siswa->nama_siswa }} </td>
	</tr>
	<tr>
		<td style="width: 75px;" >Nomor Induk Siswa</td>
		<td style="width: 35px">:</td>
		<td>{{ $siswa->nis }} </td>
	</tr>
	<tr>
		<td style="width: 75px">Kelas</td>
		<td style="width: 15px">:</td>
		<td>{{ $siswa->kelas['kelas'] }} {{ $siswa->kelas['tipe_kelas'] }} </td>
	</tr>
</table>
<br>
<hr style="margin-bottom: 4px">
<div style="height: 5px"></div>
<table>
	<tr>
		<td class="garis" style="width: 150px">Jumlah Soal</td>
		<td class="garis" style="width: 250px">{{ $jumlah_soal }} soal</td>
	</tr>
	<tr>
		<td class="garis">Soal Dijawab</td>
		<td class="garis">{{ $jawabs->count() }} soal</td>
	</tr>
	<tr>
		<td class="garis">Jawaban Benar</td>
		<td class="garis">{{ $jawabBenar->count() }} soal</td>
	</tr>
	<tr>
		<td class="garis">Nilai</td>
		<td class="garis">{{ $jumlah_jawaban_benar->jumlahNilai }}</td>
	</tr>
</table>
