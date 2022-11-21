<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->string('title_am');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('description_am');
            $table->string('description_en');
            $table->string('description_ru');
            $table->integer('image_id');
            $table->integer('ordering');
            $table->integer('published')->default(0);
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
        Schema::dropIfExists('home');
    }
};
