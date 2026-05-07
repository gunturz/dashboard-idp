<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 4 nilai keputusan baru ke enum status_promotion
        DB::statement("ALTER TABLE promotion_plan MODIFY COLUMN status_promotion ENUM(
            'Draft',
            'In Progress',
            'Pending Panelis',
            'Approved Panelis',
            'Rejected Panelis',
            'Ready',
            'Promoted',
            'Not Promoted',
            'Ready Now',
            'Ready in 1-2 Years',
            'Ready in > 2 Years',
            'Not Ready'
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
            'Promoted',
            'Not Promoted'
        ) NOT NULL DEFAULT 'Draft'");
    }
};
