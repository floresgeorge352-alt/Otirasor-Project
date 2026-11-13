<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BackupHistory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Throwable;

class BackupService
{
    public function runDatabaseBackup(string $type = 'manual', ?int $userId = null): BackupHistory
    {
        $history = BackupHistory::create([
            'filename'   => 'pending',
            'disk'       => config('backup.disk', 'local'),
            'path'       => 'pending',
            'type'       => $type,
            'status'     => 'in_progress',
            'created_by' => $userId,
        ]);

        try {
            $filename = 'db-backup-' . now()->format('Y-m-d_H-i-s') . '.sql';
            $relative = 'backups/' . $filename;
            $absolute = storage_path('app/' . $relative);

            File::ensureDirectoryExists(dirname($absolute));

            $this->dumpDatabase($absolute);

            if (! File::exists($absolute) || File::size($absolute) === 0) {
                throw new \RuntimeException('Backup file is empty or was not created.');
            }

            $history->update([
                'filename'   => $filename,
                'path'       => $relative,
                'size_bytes' => File::size($absolute),
                'status'     => 'success',
            ]);

            return $history;
        } catch (Throwable $e) {
            Log::error('Backup failed: ' . $e->getMessage());

            $history->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function dumpDatabase(string $outputPath): void
    {
        $config = config('database.connections.' . config('database.default'));

        if ($config['driver'] !== 'mysql') {
            throw new \RuntimeException('Only MySQL/MariaDB supported.');
        }

        // Handle blank password for XAMPP
        $passwordPart = !empty($config['password']) ? '--password=' . escapeshellarg($config['password']) : '';

        $command = sprintf(
            '"%s" --user=%s %s --host=%s --port=%s --single-transaction --quick --lock-tables=false --result-file=%s %s',
            config('backup.mysql_dump_path'),
            escapeshellarg($config['username']),
            $passwordPart,
            escapeshellarg($config['host']),
            escapeshellarg((string) ($config['port'] ?? 3306)),
            escapeshellarg($outputPath),
            escapeshellarg($config['database'])
        );

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new \RuntimeException('mysqldump failed: ' . $process->getErrorOutput());
        }
    }

    public function restore(BackupHistory $history): void
    {
        if (! $history->existsOnDisk()) {
            throw new \RuntimeException('Backup file not found on disk.');
        }

        $absolute = storage_path('app/' . $history->path);
        $config = config('database.connections.' . config('database.default'));

        // Handle blank password for XAMPP
        $passwordPart = !empty($config['password']) ? '--password=' . escapeshellarg($config['password']) : '';

        $command = sprintf(
            '"%s" --user=%s %s --host=%s --port=%s %s',
            config('backup.mysql_path'),
            escapeshellarg($config['username']),
            $passwordPart,
            escapeshellarg($config['host']),
            escapeshellarg((string) ($config['port'] ?? 3306)),
            escapeshellarg($config['database'])
        );

        $process = Process::fromShellCommandline($command);
        
        // Ito ang sikreto: ipasa ang file content via stdin
        $process->setInput(fopen($absolute, 'r'));
        
        $process->setTimeout(600);
        $process->run();

        if (! $process->isSuccessful()) {
            $errorMsg = trim($process->getErrorOutput()) ?: trim($process->getOutput());
            throw new \RuntimeException('Restore failed: ' . $errorMsg);
        }

        Log::warning('Database restored from backup', [
            'backup_id' => $history->id,
            'filename'  => $history->filename,
        ]);
    }

    public function cleanup(int $keepDays = null): int
    {
        $keepDays = $keepDays ?? (int) config('backup.keep_days', 30);
        $cutoff = now()->subDays($keepDays);
        $deleted = 0;

        BackupHistory::where('created_at', '<', $cutoff)->each(function ($backup) use (&$deleted) {
            if ($backup->existsOnDisk()) {
                Storage::disk($backup->disk)->delete($backup->path);
            }
            $backup->delete();
            $deleted++;
        });

        return $deleted;
    }
}