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

        Schema::create('promotion_plan', function (Blueprint $table) {
            $table->id(); // PK id [cite: 149]
            $table->foreignId('user_id_talent')->constrained('users'); // FK user_id(kandidat) [cite: 153]
            $table->foreignId('target_position_id')->constrained('position'); // Key target position_id [cite: 161]
            $table->json('mentor_ids')->nullable(); // Array of mentor user IDs
            $table->enum('status_promotion', ['Draft', 'In Progress', 'Pending Panelis', 'Approved Panelis', 'Rejected Panelis', 'Ready', 'Promoted']); // Key status_promotion [cite: 168]
            $table->date('start_date'); // Key start date [cite: 175]
            $table->date('target_date'); // Key target_date [cite: 182]
            $table->timestamps();
        });

        Schema::create('idp_activity', function (Blueprint $table) {
            $table->id(); // PK id [cite: 186]
            $table->foreignId('user_id_talent')->constrained('users'); // FK user_id(kandidat) [cite: 193]
            $table->foreignId('type_idp')->constrained('idp_type'); // FK type_id [cite: 198]
            $table->foreignId('verify_by')->nullable()->constrained('users'); // FK verify_by [cite: 235]
            $table->string('theme'); // Key theme [cite: 210]
            $table->date('activity_date'); // Key activity_date [cite: 203]
            $table->string('location'); // Key location [cite: 207]
            $table->string('activity'); // Key activity [cite: 214]
            $table->text('description'); // Key description [cite: 218]
            $table->text('action_plan'); // Key action_plan [cite: 221]
            $table->string('document_path'); // Key document_path [cite: 224]
            $table->enum('status', ['Pending', 'Approved', 'Rejected']); // Key status [cite: 217]
            $table->string('platform'); // Key platform [cite: 227]
            $table->timestamps();
        });

        Schema::create('improvement_project', function (Blueprint $table) {
            $table->id(); // PK id [cite: 151]
            $table->foreignId('user_id_talent')->constrained('users'); // FK user_id(kandidat) [cite: 160]
            $table->string('title'); // Key title [cite: 166]
            $table->string('document_path'); // Key document_path [cite: 173]
            $table->enum('status', ['On Progress', 'Pending', 'Verified', 'Rejected']); // Key status [cite: 180]
            $table->foreignId('verify_by')->nullable()->constrained('users'); // FK verify_by [cite: 235]
            $table->dateTime('verify_at')->nullable(); // Key verify_at [cite: 247]
            $table->text('feedback')->nullable(); // Catatan admin / finance notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // idp_type table is dropped by earlier migration (create_core_identity_tables)
        Schema::dropIfExists('promotion_plan');
        Schema::dropIfExists('idp_activity');
        Schema::dropIfExists('improvement_project');
    }
};
