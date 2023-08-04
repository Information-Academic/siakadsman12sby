<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipe_ulangan',['UH','UTS','UAS']);
            $table->longText('soal');
            $table->string('jawaban',500);
            $table->enum('pilihan_ganda',['A','B','C','D']);
            $table->integer('siswas_id');
            $table->integer('ulangans_id');
            $table->double('nilai_ulangan');
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
        Schema::dropIfExists('ulangans');
    }
}
