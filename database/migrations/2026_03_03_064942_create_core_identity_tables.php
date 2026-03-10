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
        // 1. BUAT TABEL REFERENSI (Tanpa foreign key)
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('nama_company');
            $table->timestamps();
        });

        Schema::create('department', function (Blueprint $table) {
            $table->id();
            $table->string('nama_department');
            $table->timestamps();
        });

        Schema::create('position', function (Blueprint $table) {
            $table->id();
            $table->string('position_name');
            $table->tinyInteger('grade_level');
            $table->timestamps();
        });

        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->timestamps();
        });

        Schema::create('idp_type', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->timestamps();
        });

        // 2. BUAT TABEL USERS (Membutuhkan company, department, position)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('email')->unique();
            $table->foreignId('company_id')->constrained('company');
            $table->foreignId('department_id')->constrained('department');
            $table->foreignId('position_id')->constrained('position');
            $table->foreignId('role_id')->constrained('role');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->timestamps();
        });

        // Tambahkan FK self-referencing setelah tabel users selesai dibuat
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('mentor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('atasan_id')->references('id')->on('users')->nullOnDelete();
        });

        // 3. BUAT TABEL PIVOT/RELASI (Membutuhkan users dan role)
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_role')->constrained('role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus dalam urutan terbalik untuk menghindari error constraint
        Schema::dropIfExists('user_role');
        // Hapus FK self-referencing dulu sebelum drop tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['mentor_id']);
            $table->dropForeign(['atasan_id']);
        });
        Schema::dropIfExists('users');
        Schema::dropIfExists('idp_type');
        Schema::dropIfExists('role');
        Schema::dropIfExists('position');
        Schema::dropIfExists('department');
        Schema::dropIfExists('company');
    }
};
