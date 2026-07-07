<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version {--json : Output as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the current application version';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $versionConfig = config('version');
        $version = $versionConfig['current'] ?? '0.0.0';
        $build = $versionConfig['build'] ?? [];

        if ($this->option('json')) {
            $this->line(json_encode([
                'version' => $version,
                'build' => $build,
                'environment' => app()->environment(),
                'php_version' => phpversion(),
            ], JSON_PRETTY_PRINT));

            return self::SUCCESS;
        }

        $this->info('═══════════════════════════════════');
        $this->info('🚀 CESIZen Application Information');
        $this->info('═══════════════════════════════════');
        $this->line('');

        $this->line('<fg=cyan>Version:</> <fg=green>' . $version . '</>');
        $this->line('<fg=cyan>Environment:</> <fg=green>' . app()->environment() . '</>');
        $this->line('<fg=cyan>PHP Version:</> <fg=green>' . phpversion() . '</>');

        if (!empty($build['timestamp'])) {
            $this->line('<fg=cyan>Build Timestamp:</> <fg=green>' . $build['timestamp'] . '</>');
        }

        if (!empty($build['commit'])) {
            $this->line('<fg=cyan>Build Commit:</> <fg=green>' . substr($build['commit'], 0, 8) . '</>');
        }

        if (!empty($build['branch'])) {
            $this->line('<fg=cyan>Branch:</> <fg=green>' . $build['branch'] . '</>');
        }

        $this->line('');
        $this->info('═══════════════════════════════════');

        return self::SUCCESS;
    }
}
