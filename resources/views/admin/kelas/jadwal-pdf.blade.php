<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak Jadwal Kelas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shrotcut icon" href="{{ asset('img/favicon.ico') }}">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <table class="table table-bordered table-striped table-hover" width="100%">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">Daftar Jadwal Kelas {{ $kelas->kelas .' '. $kelas->tipe_kelas }}</th>
                    </tr>
                    <tr>
                        <th>Hari</th>
                        <th>Mata Pelajaran</th>
                        <th>Nama Guru</th>
                        <th>Jam Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach ($guru as $g)
                    <td style="text-align: center;">{{ $g->hari['nama_hari']}}</td>
                    <td style="text-align: center;">{{ $g->mapel['nama_mapel'] }}</td>
                    <td style="text-align: center;">{{ $g->nama_guru }}</td>
                    <td style="text-align: center;">{{$g->jadwal['jam_mulai']}}</td>
                    @endforeach
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-center"><strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> :: <a href="">SIAKAD Sekolah</a>. </strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
