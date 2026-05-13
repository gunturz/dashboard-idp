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
        echo "Cleaning up sessions for: " . ($user->nama ?? $d->user_id_talent) . "\n";
        
        $sessions = DB::table('assessment_session')
            ->where('user_id_talent', $d->user_id_talent)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Keep the first (latest) session active, deactivate the rest
        $latest = $sessions->shift();
        echo "  - Keeping Session ID: {$latest->id} (Created at: {$latest->created_at})\n";
        
        foreach ($sessions as $s) {
            echo "  - Deactivating Session ID: {$s->id} (Created at: {$s->created_at})\n";
            DB::table('assessment_session')->where('id', $s->id)->update(['is_active' => false]);
        }
    }
    echo "Cleanup finished.\n";
}
