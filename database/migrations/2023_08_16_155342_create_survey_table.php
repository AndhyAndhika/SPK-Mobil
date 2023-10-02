<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('id_user');
            // $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('no_telp')->nullable();
            $table->integer('K1')->nullable();
            $table->integer('K2')->nullable();
            $table->integer('K3')->nullable();
            $table->integer('K4')->nullable();
            $table->integer('K5')->nullable();
            $table->integer('K6')->nullable();
            $table->integer('K7')->nullable();
            $table->integer('K8')->nullable();
            $table->integer('K9')->nullable();
            $table->integer('K10')->nullable();
            $table->integer('K11')->nullable();
            $table->integer('K12')->nullable();
            $table->integer('K13')->nullable();
            $table->integer('total_nilai')->nullable();
            $table->string('hasil')->nullable();
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
        Schema::dropIfExists('survey');
    }
}
