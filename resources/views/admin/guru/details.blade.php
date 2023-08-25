@extends('template_backend.home')
@section('heading', 'Details Guru')
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('guru.index') }}">Guru</a></li>
  <li class="breadcrumb-item active">Details Guru</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a href="{{ route("guru.mapel", Crypt::encrypt($guru->mapels_id)) }}" class="btn btn-default btn-sm"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a>
        </div>
        <div class="card-body">
            <div class="row no-gutters ml-2 mb-2 mr-2">
                <div class="col-md-4">
                    <img src="{{ asset($guru->foto_guru) }}" class="card-img img-details" alt="...">
                </div>
                <div class="col-md-1 mb-4"></div>
                <div class="col-md-7">
                    <h5 class="card-title card-text mb-2">Nama : {{ $guru->nama_guru }}</h5>
                    <h5 class="card-title card-text mb-2">NIP : {{ $guru->nip }}</h5>
                    <h5 class="card-title card-text mb-2">Alamat : {{ $guru->alamat }}</h5>
                    <h5 class="card-title card-text mb-2">Guru Mapel : {{ $guru->mapel['nama_mapel'] }}</h5>
                    @if ($guru->jenis_kelamin == 'L')
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Laki-laki</h5>
                    @else
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Perempuan</h5>
                    @endif
                    <h5 class="card-title card-text mb-2">Tempat Lahir : {{ $guru->tempat_lahir }}</h5>
                    <h5 class="card-title card-text mb-2">Tanggal Lahir : {{ date('d F Y', strtotime($guru->tanggal_lahir)) }}</h5>
                    <h5 class="card-title card-text mb-2">No. Telepon : {{ $guru->no_telepon }}</h5>
                    @if ($guru->status_guru == 'Pns')
                        <h5 class="card-title card-text mb-2">Status Guru : PNS</h5>
                    @elseif($guru->status_guru == 'Honorer')
                        <h5 class="card-title card-text mb-2">Status Guru : Honorer</h5>
                    @else
                        <h5 class="card-title card-text mb-2">Status Guru : Tidak Tetap</h5>
                    @endif
                    @if ($guru->status_pegawai == 'Aktif')
                        <h5 class="card-title card-text mb-2">Status Pegawai : Aktif</h5>
                    @else
                        <h5 class="card-title card-text mb-2">Status Pegawai : Tidak Aktif</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataGuru").addClass("active");
    </script>
@endsection