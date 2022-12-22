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
        Schema::create('contact_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('pay_allowed')->default(0);
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
        Schema::dropIfExists('contact_user');
    }
};
