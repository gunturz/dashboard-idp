<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->unsignedBigInteger('perusahaan_id')->nullable()->change();
            $table->unsignedBigInteger('department_id')->nullable()->change();
            $table->unsignedBigInteger('position_id')->nullable()->change();
            $table->unsignedBigInteger('role_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->unsignedBigInteger('perusahaan_id')->nullable(false)->change();
            $table->unsignedBigInteger('department_id')->nullable(false)->change();
            $table->unsignedBigInteger('position_id')->nullable(false)->change();
            $table->unsignedBigInteger('role_id')->nullable(false)->change();
        });
    }
};
