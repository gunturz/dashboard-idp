<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_session', function (Blueprint $table) {
            $table->dropForeign(['user_id_atasan']);
            $table->unsignedBigInteger('user_id_atasan')->nullable()->change();
            $table->foreign('user_id_atasan')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('assessment_session', function (Blueprint $table) {
            $table->dropForeign(['user_id_atasan']);
            $table->unsignedBigInteger('user_id_atasan')->nullable(false)->change();
            $table->foreign('user_id_atasan')->references('id')->on('users');
        });
    }
};
