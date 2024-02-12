<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak Siswa SMA Negeri 12 Surabaya</title>
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
                        <th colspan="4" class="text-center">Daftar Murid Kelas {{ $kelas->kelas .' '. $kelas->tipe_kelas }}</th>
                    </tr>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Status Siswa</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach ($siswa as $s)
                    <td style="text-align: center;">{{ $s->nis }}</td>
                    <td style="text-align: center;">{{ $s->nama_siswa }}</td>
                    <td style="text-align: center;">{{ $s->jenis_kelamin }}</td>
                    <td style="text-align: center;">{{$s->no_telepon}}</td>
                    <td style="text-align: center;">{{ $s->alamat }}</td>
                    <td style="text-align: center;">{{ $s->tempat_lahir }}</td>
                    <td style="text-align: center;">{{ $s->tanggal_lahir }}</td>
                    <td style="text-align: center;">{{ $s->status_siswa }}</td>
                    @endforeach
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-center"><strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> :: <a href="">SMA Negeri 12 Surabaya</a>. </strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
