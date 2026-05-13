<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DependencyAudit extends Command
{
    protected $signature = 'security:dependency-audit {--notify : Kirim email jika ada vulnerability}';
    protected $description = 'Jalankan composer audit untuk cek vulnerability dependency';

    public function handle(): int
    {
        $this->info('Menjalankan composer audit...');

        // Jalankan composer audit dalam format JSON
        $output = [];
        $returnCode = 0;
        $basePath = base_path();

        exec(
            "cd {$basePath} && composer audit --format=json 2>&1",
            $output,
            $returnCode
        );

        $jsonOutput = implode("\n", $output);
        $auditData = json_decode($jsonOutput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->warn('composer audit output tidak bisa diparsing sebagai JSON.');
            $this->line($jsonOutput);
            return self::FAILURE;
        }

        $advisories = $auditData['advisories'] ?? [];
        $totalVulns = count($advisories);

        if ($totalVulns === 0) {
            $this->info('✅ Tidak ada vulnerability yang ditemukan!');
            Log::channel('security_log')->info('Dependency audit: BERSIH', [
                'total_packages' => $auditData['packages'] ?? 'unknown',
            ]);
            return self::SUCCESS;
        }

        // Ada vulnerability
        $this->error("❌ Ditemukan {$totalVulns} vulnerability!");

        foreach ($advisories as $package => $vulnList) {
            $this->line("\n📦 Package: {$package}");
            foreach ($vulnList as $vuln) {
                $this->warn("  ⚠ [{$vuln['severity']}] {$vuln['title']}");
                $this->line("    CVE: " . ($vuln['cve'] ?? 'N/A'));
                $this->line("    Link: " . ($vuln['link'] ?? 'N/A'));
            }
        }

        Log::channel('security_log')->critical('Dependency audit: VULNERABILITY DITEMUKAN', [
            'total' => $totalVulns,
            'advisories' => $advisories,
        ]);

        // Kirim notifikasi email
        if ($this->option('notify')) {
            $adminEmail = env('SECURITY_ALERT_EMAIL');
            if ($adminEmail) {
                $body = "🚨 Dashboard IDP — Dependency Vulnerability Alert\n\n";
                $body .= "Ditemukan {$totalVulns} vulnerability pada dependency:\n\n";

                foreach ($advisories as $package => $vulnList) {
                    $body .= "📦 {$package}:\n";
                    foreach ($vulnList as $vuln) {
                        $body .= "  • [{$vuln['severity']}] {$vuln['title']}\n";
                        $body .= "    CVE: " . ($vuln['cve'] ?? 'N/A') . "\n";
                    }
                    $body .= "\n";
                }

                $body .= "Segera jalankan: composer update [package-name]";

                \Illuminate\Support\Facades\Mail::raw(
                    $body,
                    fn($m) => $m->to($adminEmail)
                        ->subject('[SECURITY] Vulnerability Ditemukan - Dashboard IDP')
                );
            }
        }

        return self::FAILURE;
    }
}
