<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip',30);
            $table->string('nama_guru',200);
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('no_telepon',30)->nullable();
            $table->string('tempat_lahir',255);
            $table->date('tanggal_lahir');
            $table->enum('status_guru',['L','P']);
            $table->string('foto_guru',255);
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
        Schema::dropIfExists('gurus');
    }
}
