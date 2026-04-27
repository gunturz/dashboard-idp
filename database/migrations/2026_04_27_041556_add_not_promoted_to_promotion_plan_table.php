<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modify ENUM column to add 'Not Promoted'
        DB::statement("ALTER TABLE promotion_plan MODIFY COLUMN status_promotion ENUM(
            'Draft',
            'In Progress',
            'Pending Panelis',
            'Approved Panelis',
            'Rejected Panelis',
            'Ready',
            'Promoted',
            'Not Promoted'
        ) NOT NULL DEFAULT 'Draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE promotion_plan MODIFY COLUMN status_promotion ENUM(
            'Draft',
            'In Progress',
            'Pending Panelis',
            'Approved Panelis',
            'Rejected Panelis',
            'Ready',
            'Promoted'
        ) NOT NULL DEFAULT 'Draft'");
    }
};
