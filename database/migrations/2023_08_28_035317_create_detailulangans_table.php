<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailulangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailulangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ulangans_id');
            $table->longText('soal');
            $table->longText('pila');
            $table->longText('pilb');
            $table->longText('pilc');
            $table->longText('pild');
            $table->longText('pile');
            $table->string('kunci', 1);
            $table->decimal('nilai', 5)->nullable();
            $table->string('status', 1);
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
        Schema::dropIfExists('detailulangans');
    }
}
