<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->string('nama_siswa',255);
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('nomor_telepon',20)->nullable();
            $table->string('tempat_lahir',255);
            $table->date('tanggal_lahir');
            $table->string('foto_siswa',200);
            $table->enum('status_siswa',['Aktif','Tidak Aktif']);
            $table->integer('users_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswas');
    }
}
