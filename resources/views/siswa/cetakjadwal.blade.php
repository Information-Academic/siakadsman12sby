<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Kelas Siswa</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
</head>
<body>
<div class="container-fluid py-4">
    <h2 style="text-align: center;">Jadwal Mata Pelajaran </h2>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" border="0.5">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Hari</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Mata Pelajaran
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jam Pelajaran
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kelas
                                    </th>
                                    <th
                                        class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tipe Kelas
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $j)
                                <tr>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{ $j->hari['nama_hari'] }}</span>
                                    </td>

                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold" >{{ $j->mapel['nama_mapel'] }}</span>
                                    </td>

                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{ $j->jam_mulai }} -
                                            {{ $j->jam_selesai }}</span>
                                        </span>
                                    </td>

                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{ $j->kelas['kelas'] }}</span>
                                        </span>
                                    </td>

                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{ $j->kelas['tipe_kelas'] }}</span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>
