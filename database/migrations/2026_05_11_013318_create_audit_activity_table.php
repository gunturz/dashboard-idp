<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_activity', function (Blueprint $table) {
            $table->id();

            // Siapa yang melakukan aksi (null jika user belum login / sistem)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Tipe event: 'login_success', 'login_failed', 'password_reset',
            //             'role_change', 'file_upload', 'file_download',
            //             'file_download_unauthorized', 'user_updated', dll.
            $table->string('event', 100);

            // Deskripsi human-readable: "Admin login dari IP 192.168.1.1"
            $table->string('description')->nullable();

            // Data tambahan dalam format JSON (IP, browser, nama file, dll)
            $table->json('properties')->nullable();

            // IP address user saat event terjadi
            $table->string('ip_address', 45)->nullable();

            // User-Agent browser
            $table->string('user_agent')->nullable();

            // Timestamps (created_at = waktu kejadian)
            $table->timestamps();

            // Index untuk query cepat
            $table->index('event');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_activity');
    }
};
