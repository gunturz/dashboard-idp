<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$duplicates = DB::table('assessment_session')
    ->where('is_active', true)
    ->select('user_id_talent', DB::raw('count(*) as count'))
    ->groupBy('user_id_talent')
    ->having('count', '>', 1)
    ->get();

if ($duplicates->isEmpty()) {
    echo "No duplicate active sessions found.\n";
} else {
    foreach ($duplicates as $d) {
        $user = DB::table('users')->find($d->user_id_talent);
        echo "User: " . ($user->nama ?? $d->user_id_talent) . " has " . $d->count . " active sessions.\n";
        
        // List sessions
        $sessions = DB::table('assessment_session')
            ->where('user_id_talent', $d->user_id_talent)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        foreach ($sessions as $index => $s) {
             echo "  - Session ID: " . $s->id . " created at: " . $s->created_at . ($index == 0 ? " (LATEST)" : " (OLD)") . "\n";
        }
    }
}
