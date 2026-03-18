<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('promotion_plan', 'mentor_ids')) {
    Schema::table('promotion_plan', function (Blueprint $table) {
        $table->json('mentor_ids')->nullable()->after('target_position_id');
    });
    echo "Column 'mentor_ids' added successfully.\n";
}
else {
    echo "Column 'mentor_ids' already exists.\n";
}
