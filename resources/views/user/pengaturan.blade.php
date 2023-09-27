@extends('template_backend.home')
@section('heading', 'Profile')
@section('page')
  <li class="breadcrumb-item active">User Profile</li>
@endsection
@section('content')
<div class="col-12">
    <div class="row">
        <div class="col-5">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                    @if (Auth::user()->roles == 'Guru')
                        <a href="{{ asset(Auth::user()->guru(Auth::user()->nip)->foto_guru) }}" data-toggle="lightbox" data-title="Foto {{ Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang }}" data-gallery="gallery" data-footer='<a href="{{ route('pengaturan.edit-foto') }}" id="linkFotoGuru" class="btn btn-link btn-block btn-light"><i class="nav-icon fas fa-file-upload"></i> &nbsp; Ubah Foto</a>'>
                            <img src="{{ asset(Auth::user()->guru(Auth::user()->nip)->foto_guru) }}" width="130px" class="profile-user-img img-fluid img-circle" alt="User profile picture">
                        </a>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <a href="{{ asset(Auth::user()->siswa(Auth::user()->nis)->foto_siswa) }}" data-toggle="lightbox" data-title="Foto {{ Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang }}" data-gallery="gallery" data-footer='<a href="{{ route('pengaturan.edit-foto') }}" id="linkFotoGuru" class="btn btn-link btn-block btn-light"><i class="nav-icon fas fa-file-upload"></i> &nbsp; Ubah Foto</a>'>
                            <img src="{{ asset(Auth::user()->siswa(Auth::user()->nis)->foto_siswa) }}" width="130px" class="profile-user-img img-fluid img-circle" alt="User profile picture">
                        </a>
                    @else
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/male.jpg') }}" alt="User profile picture">
                    @endif
                    </div>
                    <h3 class="profile-username text-center">{{ Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang }}</h3>
                    <p class="text-muted text-center">{{ Auth::user()->roles }}</p>
                    @if (Auth::user()->roles == 'Guru')
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>NIP</b> <a class="float-right">{{ Auth::user()->guru(Auth::user()->nip)->nip }}</a>
                            </li>
                        </ul>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>NIS</b> <a class="float-right">{{ Auth::user()->siswa(Auth::user()->nis)->nis }}</a>
                            </li>
                        </ul>
                    @else
                    @endif
                    <a href="{{ route('pengaturan.profile') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Akun</h3>
                </div>
                <div class="card-body">
                    <table class="table" style="margin-top: -21px;">
                    <tr>
                        <td width="50"><i class="nav-icon fas fa-envelope"></i></td>
                        <td>Ubah Email</td>
                        <td width="50"><a href="{{ route('pengaturan.email') }}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                    <tr>
                        <td width="50"><i class="nav-icon fas fa-key"></i></td>
                        <td>Ubah Password</td>
                        <td width="50"><a href="{{ route('pengaturan.password') }}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->

        <div class="col-7">
            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <hr>

                    @if (Auth::user()->roles == 'Guru')
                        <strong><i class="fas fa-book mr-1"></i> Guru Mapel</strong>
                        <p class="text-muted">{{ Auth::user()->guru(Auth::user()->nip)->mapel->nama_mapel }}</p>
                        <hr>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <strong><i class="fas fa-home mr-1"></i> Tempat Lahir</strong>
                        <p class="text-muted">{{ Auth::user()->siswa(Auth::user()->nis)->kelas->nama_kelas }}</p>
                        <hr>
                    @else
                    @endif

                    @if (Auth::user()->roles == 'Guru')
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat Lahir</strong>
                        <p class="text-muted">{{ Auth::user()->guru(Auth::user()->nip)->tempat_lahir }}</p>
                        <hr>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat Lahir</strong>
                        <p class="text-muted">{{ Auth::user()->siswa(Auth::user()->nis)->tempat_lahir }}</p>
                        <hr>
                    @else
                    @endif

                    @if (Auth::user()->roles == 'Guru')
                        <strong><i class="far fa-calendar mr-1"></i> Tanggal Lahir</strong>
                        <p class="text-muted">{{ date('l, d F Y', strtotime(Auth::user()->guru(Auth::user()->nip)->tanggal_lahir)) }}</p>
                        <hr>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <strong><i class="far fa-calendar mr-1"></i> Tanggal Lahir</strong>
                        <p class="text-muted">{{ date('l, d F Y', strtotime(Auth::user()->siswa(Auth::user()->nis)->tanggal_lahir)) }}</p>
                        <hr>
                    @else
                    @endif

                    @if (Auth::user()->roles == 'Guru')
                        <strong><i class="fas fa-phone mr-1"></i> No Telepon / WA</strong>
                        <p class="text-muted">{{ Auth::user()->guru(Auth::user()->nip)->no_telepon }}</p>
                    @elseif (Auth::user()->roles == 'Siswa')
                        <strong><i class="fas fa-phone mr-1"></i> No Telepon / WA</strong>
                        <p class="text-muted">{{ Auth::user()->siswa(Auth::user()->nis)->no_telepon }}</p>
                    @else
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
@endsection
