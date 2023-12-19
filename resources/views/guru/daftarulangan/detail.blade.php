@extends('layouts.soal')
@section('title')
@section('breadcrumb')
  <h1>Detail Siswa</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="{{ url('/master/siswa') }}">Siswa</a></li>
    <li class="active">Detail</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-4">
  <div class="box box-primary">
    <div class="box-body box-profile">

      <table class="table table-condensed table-hover">
        <tr>
          <td width="75px">Nama</td>
          <td width="10px">:</td>
          <td>{{ $siswa->nama_depan }} {{$siswa->nama_belakang}}</td>
        </tr>
        <tr>
          <td>NIS</td>
          <td>:</td>
          <td>{{ $siswa->nis }}</td>
        </tr>
        <tr>
          <td>Kelas</td>
          <td>:</td>
          <td>{{ $siswa2->kelas->kelas }} {{$siswa2->kelas->tipe_kelas}}</td>
        </tr>
        <tr>
          <td>Jenis Kelamin</td>
          <td>:</td>
          <td>
            @if($siswa2->jenis_kelamin == 'L')
              Laki-laki
            @else
              Perempuan
            @endif
          </td>
        </tr>
      </table>
      <hr>
    </div>
    <!-- /.box-body -->
  </div>
</div>
<div class="col-md-8">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Ujian & Latihan</h3>
    </div>
    <div class="box-body">
      <table class="table table-hover table-condensed">
        <caption><i>Daftar ujian & latihan <b>{{ $siswa->nama_depan }} {{$siswa->nama_belakang}}</b>.</i></caption>
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Paket Soal</th>
            {{-- <th style="width: 70px; text-align: center;">Nilai</th> --}}
            <th style="width: 100px; text-align: center;">Tanggal</th>
            <th style="width: 160px; text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>

          @if($hasil_ujians->count())
            <?php $no = $hasil_ujians->firstItem(); ?>
            @foreach($hasil_ujians as $hasil_ujian)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $hasil_ujian->tipe_ulangan }} {{$hasil_ujian->mapel->nama_mapel}}</td>
              {{-- <td style="text-align: center;">{{ $hasil_ujian->jumlah_nilai }}</td> --}}
              <td style="text-align: center;">
              <?php
                $exp_date = explode(" ", $hasil_ujian->created_at);
                $exp_date = explode("-", $exp_date[0]);
                echo $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
              ?>
              </td>
              <td style="text-align: center;">
                <a href="{{ url('laporan/'.$hasil_ujian->ulangans_id.'/'.$hasil_ujian->users_id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Lihat rincian soal dan jawaban siswa.">Detail</a>
              </td>
            </tr>
            @endforeach
          @else
            <tr><td colspan="5" class="alert alert-danger">Belum ada soal Anda yang dikerjakan.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
