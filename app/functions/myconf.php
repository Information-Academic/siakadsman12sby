<?php
	function getRoles($roles){
		if ($roles != "") {
			if ($roles == 'Admin') {
				$status_user = 'Admin';
			}elseif($roles == 'Guru'){
				$status_user = 'Guru';
			}else{
				$status_user = 'Siswa';
			}
		}else{
			$status_user = 'Invalid';
		}
		return $status_user;
	}
	function getJenisSoal($tipe_ulangan){
		if ($tipe_ulangan != "") {
			if ($tipe_ulangan == 'UH') {
				$jenis = 'Soal Ulangan Harian';
			}else if($tipe_ulangan == 'UTS'){
				$jenis = 'Soal Ulangan Tengah Semester';
			}
            else if($tipe_ulangan == 'UAS'){
                $jenis = 'Soal Ulangan Akhir Semester';
            }
		}else{
			$jenis = 'Invalid';
		}
		return $jenis;
	}
	function timeStampIndo($tgl) {
		if ($tgl != "") {
			$exp_tgl = explode(" ", $tgl);
			$tgl_exp = explode("-", $exp_tgl[0]);
			$waktu_exp = explode(":", $exp_tgl[1]);
			$tanggal = $tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0].' '.$waktu_exp[0].':'.$waktu_exp[1].':'.$waktu_exp[2];

		}else{
			$tanggal = 'error';
		}
		return $tanggal;
	}
	function timeStampIndoOnly($tgl) {
		if ($tgl != "") {
			$exp_tgl = explode(" ", $tgl);
			$tgl_exp = explode("-", $exp_tgl[0]);
			$waktu_exp = explode(":", $exp_tgl[1]);
			$tanggal = $tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0];

		}else{
			$tanggal = 'error';
		}
		return $tanggal;
	}
	function jenisSoal($tipe_ulangan) {
        if ($tipe_ulangan != "") {
			if ($tipe_ulangan == 'UH') {
				$jenis = 'Soal Ulangan Harian';
			}else if($tipe_ulangan == 'UTS'){
				$jenis = 'Soal Ulangan Tengah Semester';
			}
            else if($tipe_ulangan == 'UAS'){
                $jenis = 'Soal Ulangan Akhir Semester';
            }
		}else{
			$jenis = 'Invalid';
		}
		return $jenis;
	}
?>