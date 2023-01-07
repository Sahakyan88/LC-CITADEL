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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_am')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ru')->nullable();
            $table->text('body_am')->nullable();
            $table->text('body_ru')->nullable();
            $table->text('body_en')->nullable();
            $table->longText('price')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('file_id')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('ordering')->nullable();
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
        Schema::dropIfExists('services');
    }
};
