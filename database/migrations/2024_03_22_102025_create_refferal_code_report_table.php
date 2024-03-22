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
        Schema::create('refferal_code_report', function (Blueprint $table) {
            $table->id();
            $table->foreign('reg_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('refferal_codes');
            $table->integer('refferal_by');
            $table->integer('reffered_points');
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
        Schema::dropIfExists('refferal_code_report');
    }
};
