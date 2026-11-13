<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup {--cleanup : Also delete backups older than retention days}';
    protected $description = 'Create a database backup';

    public function handle(BackupService $service): int
    {
        $this->info('Starting database backup...');

        try {
            $history = $service->runDatabaseBackup('automatic');
            $this->info("Backup created: {$history->filename} ({$history->human_size})");

            if ($this->option('cleanup')) {
                $deleted = $service->cleanup();
                $this->info("Cleaned up {$deleted} old backup(s).");
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}