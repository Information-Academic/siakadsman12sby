<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link" style="">
        <img src="{{ asset('img/sman12sby.png') }}" alt="sman12sby" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">SIAKAD SMAN 12 Sby</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (Auth::user()->roles == 'Admin')
                    <li class="nav-item" id="liDashboard">
                        <a href="{{ url('/') }}" class="nav-link" id="Home">
                            <i class="fas fa-home nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview" id="liMasterData">
                        <a href="#" class="nav-link" id="MasterData">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Master Data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('jadwal.index') }}" class="nav-link" id="DataJadwal">
                                    <i class="fas fa-calendar-alt nav-icon"></i>
                                    <p>Data Jadwal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('guru.index') }}" class="nav-link" id="DataGuru">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>Data Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kelas.index') }}" class="nav-link" id="DataKelas">
                                    <i class="fas fa-home nav-icon"></i>
                                    <p>Data Kelas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siswa.index') }}" class="nav-link" id="DataSiswa">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>Data Siswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mapel.index') }}" class="nav-link" id="DataMapel">
                                    <i class="fas fa-book nav-icon"></i>
                                    <p>Data Mapel</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('soal.index') }}" class="nav-link" id="DataUlangan" target="_blank">
                                    <i class="fas fa-paperclip nav-icon"></i>
                                    <p>Data Ulangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link" id="DataUser">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Data User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('presensikehadiran')}}" class="nav-link" id="PresensiData">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Data Presensi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('rekapdatapermohonan')}}" class="nav-link" id="RekapPermohonanData">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Rekap Data Permohonan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview" id="liNilai">
                        <a href="#" class="nav-link" id="Nilai">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>
                                Nilai
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{route('ulangan-kelas')}}" class="nav-link" id="Ulangan">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>Nilai Ulangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('rapor-kelas')}}" class="nav-link" id="Rapot">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>Nilai Rapor</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pengumuman') }}" class="nav-link" id="Pengumuman">
                            <i class="nav-icon fas fa-clipboard"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                @elseif (Auth::user()->roles == 'Guru')
                    <li class="nav-item has-treeview">
                        <a href="{{ url('/') }}" class="nav-link" id="Home">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('presensi.index') }}" class="nav-link" id="AbsenGuru">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <p>Presensi Guru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal.guru') }}" class="nav-link" id="JadwalGuru">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>Jadwal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('presensikehadiransiswa')}}" class="nav-link" id="PresensiKehadiranSiswa">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Data Presensi Siswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('status.guru') }}" class="nav-link" id="Status">
                            <i class="fas fa-check nav-icon"></i>
                            <p>Data Permohonan Guru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('soalulangan') }}" class="nav-link" id="SoalUlangan" target="_blank">
                            <i class="fas fa-paperclip nav-icon"></i>
                            <p>Soal Ulangan</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview" id="liNilaiGuru">
                        <a href="#" class="nav-link" id="NilaiGuru">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>
                                Nilai
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('daftarulangan') }}" class="nav-link" id="DaftarUlanganSiswa" target="_blank">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>Daftar Ulangan Siswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ulangan.index') }}" class="nav-link" id="UlanganGuru">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>Nilai Ulangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rapor.index') }}" class="nav-link" id="RapotGuru">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>Data Nilai Rapor</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (Auth::user()->roles == 'Siswa' && Auth::user()->siswa(Auth::user()->nis))
                    <li class="nav-item has-treeview">
                        <a href="{{ url('/') }}" class="nav-link" id="Home">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal.siswa') }}" class="nav-link" id="JadwalSiswa">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>Jadwal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('presensisiswaharian') }}" class="nav-link" id="AbsenSiswa">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <p>Presensi Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('statussiswa.siswa') }}" class="nav-link" id="StatusSiswa">
                            <i class="fas fa-check nav-icon"></i>
                            <p>Data Permohonan Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('soal.ujian') }}" class="nav-link" id="DataUlangan" target="_blank">
                            <i class="fas fa-paperclip nav-icon"></i>
                            <p>Ulangan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ulangan.siswa') }}" class="nav-link" id="UlanganSiswa">
                            <i class="fas fa-file-alt nav-icon"></i>
                            <p>Nilai Ulangan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rapor.siswa') }}" class="nav-link" id="RapotSiswa">
                            <i class="fas fa-file-alt nav-icon"></i>
                            <p>Rapor Siswa</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item has-treeview">
                        <a href="{{ url('/') }}" class="nav-link" id="Home">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
