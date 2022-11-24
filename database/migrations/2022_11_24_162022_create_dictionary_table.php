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
        Schema::create('dictionary', function (Blueprint $table) {
            $table->id();
            $table->longtext('faq_am');
            $table->longtext('faq_ru');
            $table->longtext('faq_en');
            $table->longtext('service_am');
            $table->longtext('service_ru');
            $table->longtext('service_en');
            $table->longtext('team_am');
            $table->longtext('team_ru');
            $table->longtext('team_en');
            $table->longtext('contact_am');
            $table->longtext('contact_ru');
            $table->longtext('contact_en');
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
        Schema::dropIfExists('dictionary');
    }
};
