<?php

use App\Http\Controllers\DetailSoalEssayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/login/cek_email/json', 'UserController@cek_email');
Route::get('/login/cek_password/json', 'UserController@cek_password');
Route::post('/cek-email', 'UserController@cek_email')->name('cek-email')->middleware('guest');
Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');
Route::get('/change-password', 'PasswordChangeController@edit')->name('password.change');
Route::post('/change-password', 'PasswordChangeController@update');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/jadwal/sekarang', 'JadwalController@jadwalSekarang');
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::get('/pengaturan/profile', 'UserController@edit_profile')->name('pengaturan.profile');
	Route::post('/pengaturan/ubah-profile', 'UserController@ubah_profile')->name('pengaturan.ubah-profile');
  	Route::get('/pengaturan/edit-foto', 'UserController@edit_foto')->name('pengaturan.edit-foto');
  	Route::post('/pengaturan/ubah-foto', 'UserController@ubah_foto')->name('pengaturan.ubah-foto');
  	Route::get('/pengaturan/email', 'UserController@edit_email')->name('pengaturan.email');
  	Route::post('/pengaturan/ubah-email', 'UserController@ubah_email')->name('pengaturan.ubah-email');
  	Route::get('/pengaturan/password', 'UserController@edit_password')->name('pengaturan.password');
  	Route::post('/pengaturan/ubah-password', 'UserController@ubah_password')->name('pengaturan.ubah-password');

    Route::middleware(['siswa'])->group(function () {
        Route::get('/presensisiswaharian', 'PresensiController@siswa')->name('presensisiswaharian');
        Route::post('/presensi/absen', 'PresensiController@absen')->name('presensisiswaharian.absen');
        Route::get('/jadwal/siswa', 'JadwalController@siswa')->name('jadwal.siswa');
        Route::get('/siswa/suratpermohonan','SiswaController@suratpermohonan')->name('siswa.suratpermohonan');
        Route::post('/suratpermohonansiswa/store','SiswaController@suratPermohonanSiswaStore')->name('siswa.suratPermohonanSiswaStore');
        Route::get('/statussiswa','SiswaController@statusSiswa')->name('statussiswa.siswa');
        Route::get('/cetakjadwalpdf', 'JadwalController@cetakJadwal');
        Route::get('/cetakraporpdf', 'RaporController@cetakRapor');
        Route::get('/ulangan/siswa', 'UlanganController@siswa')->name('ulangan.siswa');
        Route::get('/rapor/siswa', 'RaporController@siswa')->name('rapor.siswa');
        Route::get('/presensi/validsiswa','PresensiController@presensiValidSiswa')->name('presensiValidSiswa');
        Route::get('/detailraporsiswa/{id}','RaporController@detailRaporSiswa')->name('detailraporsiswa');

	    Route::get('ujian', 'SiswaController@ujian')->name('soal.ujian');
	    Route::get('ujian/get-detail-essay', 'SiswaController@getDetailEssay');
	    Route::get('ujian/simpan-jawaban-essay', 'SiswaController@simpanJawabanEssay');
	    Route::get('ujian/detail/{id}', 'SiswaController@detailUjian');
	    Route::get('ujian/finish/{id}', 'SiswaController@finishUjian');
	    Route::get('ujian/get-soal/{id}', 'SiswaController@getSoal');
	    Route::get('ujian/jawab', 'SiswaController@jawab');
	    Route::post('ujian/kirim-jawaban', 'SiswaController@kirimJawaban');
    });

    Route::middleware(['guru'])->group(function(){
        Route::get('/presensi', 'PresensiController@index')->name('presensi.index');
        Route::post('/presensi/store', 'PresensiController@store')->name('presensi.store');
        Route::get('/jadwal/guru', 'JadwalController@guru')->name('jadwal.guru');
        Route::get('/guru/suratpermohonan','GuruController@suratpermohonan')->name('guru.suratpermohonan');
        Route::post('/suratpermohonan/store','GuruController@suratPermohonanStore')->name('guru.suratPermohonanStore');
        Route::get('/status','GuruController@status')->name('status.guru');
        Route::get('/presensi/valid','PresensiController@presensiValid')->name('presensiValid');
        Route::get('/presensikehadiransiswa', 'PresensiController@presensiKehadiranSiswa')->name('presensikehadiransiswa');
        Route::get('/ubahstatus/{id}','PresensiController@ubahStatusSiswa')->name('ubahstatussiswa');
        Route::resource('/ulangan', 'UlanganController');
        Route::resource('/rapor', 'RaporController');
        Route::post('/catatan','RaporController@catatan')->name('rapor.catatan');
        Route::post('/kesimpulan','RaporController@kesimpulan')->name('rapor.kesimpulan');
        Route::get('/daftarulangan','GuruController@daftarUlangan')->name('daftarulangan');
        Route::get('data-siswa', 'GuruController@dataSiswa')->name('guru.data_siswa');
        Route::get('detail/{id}','GuruController@detailSiswa')->name('guru.detail_siswa');
        Route::group(['prefix' => 'laporan'], function () {
            Route::get('/', 'LaporanUlanganController@index')->name('guru.laporan');
            Route::get('/{id_soal}/{id_user}', 'LaporanUlanganController@detailLaporanSiswa')->name('guru.detailLaporanSiswa');
            Route::get('hasil-siswa-ulangan', 'LaporanUlanganController@hasilSiswa')->name('guru.hasilSiswa');
        });
        Route::get('/essay/simpan-score', 'LaporanUlanganController@simpanScore')->name('guru.simpan-score');
        Route::group(['prefix' => 'soalsiswa'], function (){
            Route::get('/soal', 'SoalController@soalUlangan')->name('soalulangan');
            Route::get('/get-soal', 'SoalController@dataSoalSiswa')->name('datasoalsiswa');
            Route::get('/ubah/{id}', 'SoalController@ubahSoalSiswa')->name('soalulangan.ubah');
            Route::get('/detail/ubah/{id}', 'SoalController@ubahDetailSoalSiswa')->name('soalulangan.ubah-detail-soal');
            Route::get('/detail/{id}', 'SoalController@detailSoalSiswa')->name('soalulangan.detail-soal');
            Route::get('/detail/data-soal/{id}', 'SoalController@detailDataSoalSiswa')->name('soalulangan.detail-data-soal');
            Route::get('/get-detail-soal', 'SoalController@dataDetailSoalSiswa')->name('soalulangan.get-detail-soal');
            Route::post('/essay/data', 'DetailSoalEssaySiswaController@dataSiswa');
            Route::resource('/essay', 'DetailSoalEssaySiswaController');
        });
        Route::group(['prefix' => 'crudsiswa'], function (){
            Route::post('simpan-soal', 'SoalController@simpanSoalSiswa');
            Route::post('terbit-soal', 'SoalController@terbitSoalSiswa');
            Route::post('simpan-detail-soal', 'SoalController@simpanDetailSoalSiswa')->name('crudsiswa.simpan-detail-soal');
            Route::post('simpan-detail-soal-via-excel', 'SoalController@simpanDetailSoalSiswaExcel');
        });
    });

    Route::middleware(['admin'])->group(function(){
        Route::get('/admin/home', 'HomeController@admin')->name('admin.home');
        Route::get('/admin/pengumuman', 'PengumumanController@index')->name('admin.pengumuman');
        Route::post('/admin/pengumuman/simpan', 'PengumumanController@simpan')->name('admin.pengumuman.simpan');
        Route::get('/guru/mapel/{id}', 'GuruController@mapel')->name('guru.mapel');
        Route::get('/guru/ubah-foto/{id}', 'GuruController@ubah_foto')->name('guru.ubah-foto');
        Route::get('/presensikehadiran', 'PresensiController@presensikehadiran')->name('presensikehadiran');
        Route::get('/siswa/kelas/{id}', 'SiswaController@kelas')->name('siswa.kelas');
        Route::get('/jadwal/view/json', 'JadwalController@view');
        Route::post('/admin/jadwal','JadwalController@store');
        Route::get('/siswa/view/json', 'SiswaController@view');
        Route::get('/siswa-pdf/{id}','SiswaController@cetak_pdf');
        Route::get('/jadwal-pdf/{id}','KelasController@cetak_pdf');
        Route::get('/siswa/kelas/{id}', 'SiswaController@kelas')->name('siswa.kelas');
        Route::get('/listsiswapdf/{id}', 'SiswaController@cetak_pdf');
        Route::get('/listjadwalpdf/{id}', 'KelasController@cetak_pdf');
        Route::get('/siswa/ubah-foto/{id}', 'SiswaController@ubah_foto')->name('siswa.ubah-foto');
        Route::post('/siswa/update-foto/{id}', 'SiswaController@update_foto')->name('siswa.update-foto');
        Route::get('/mapel/getMapelJson', 'MapelController@getMapelJson');
        Route::get('/user/export_excel', 'UserController@export_excel')->name('user.export_excel');
        Route::post('/user/import_excel', 'UserController@import_excel')->name('user.import_excel');
        Route::get('/get-soal', 'SoalController@dataSoal')->name('elearning.get-soal');
        Route::get('/get-soal-home', 'SoalController@dataSoalHome')->name('elearning.get-soal-home');
        Route::get('/get-detail-soal', 'SoalController@dataDetailSoal')->name('elearning.get-detail-soal');
        Route::post('simpan-soal', 'SoalController@simpanSoal');
        Route::get('/ulangan-kelas', 'UlanganController@create')->name('ulangan-kelas');
        Route::get('/ulangan-siswa/{id}', 'UlanganController@edit')->name('ulangan-siswa');
        Route::get('/ulangan-show/{id}', 'UlanganController@ulangan')->name('ulangan-show');
        Route::get('/rapor-kelas', 'RaporController@create')->name('rapor-kelas');
        Route::get('/rapor-siswa/{id}', 'RaporController@edit')->name('rapor-siswa');
        Route::get('/rapor-show/{id}', 'RaporController@rapor')->name('rapor-show');
        Route::get('/rekappermohonan', 'RekapPermohonanController@index')->name('rekapdatapermohonan');
        Route::resource('/guru', 'GuruController');
        Route::resource('/kelas', 'KelasController');
        Route::resource('/user', 'UserController');
        Route::resource('/mapel', 'MapelController');
        Route::resource('/siswa', 'SiswaController');
        Route::resource('/soal', 'SoalController');
        Route::resource('user', 'UserController');
        Route::resource('/jadwal','JadwalController');

        Route::group(['prefix' => 'crud'], function (){
            Route::post('simpan-soal', 'SoalController@simpanSoal');
            Route::post('terbit-soal', 'SoalController@terbitSoal');
            Route::post('simpan-detail-soal', 'SoalController@simpanDetailSoal');
            Route::post('simpan-detail-soal-via-excel', 'SoalController@simpanDetailSoalExcel');
        });
        Route::group(['prefix' => 'soal'], function (){
            Route::get('/soal', 'SoalController@index')->name('soal');
            Route::post('/essay/data', 'DetailSoalEssayController@data');
            Route::get('/ubah/{id}', 'SoalController@ubahSoal')->name('soal.ubah');
            Route::get('/detail/ubah/{id}', 'SoalController@ubahDetailSoal')->name('elearning.ubah-detail-soal');
            Route::get('/detail/{id}', 'SoalController@detail')->name('elearning.detail-soal');
            Route::get('/detail/data-soal/{id}', 'SoalController@detailDataSoal')->name('elearning.detail-data-soal');
            Route::resource('/essay', 'DetailSoalEssayController');
        });
    });
});

Route::get('/download-file-format/{filename}', 'DownloadController@download')->name('download');
