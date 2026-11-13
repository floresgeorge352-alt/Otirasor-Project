<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BackupHistory;
use App\Services\BackupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminBackupController extends Controller
{
    public function __construct(private BackupService $backups) {}

    public function index(Request $request): View
    {
        $search = trim($request->query('search', ''));

        $query = BackupHistory::with('creator')->latest();

        if ($search !== '') {
            $query->where('filename', 'like', "%{$search}%");
        }

        $backups = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => BackupHistory::count(),
            'success' => BackupHistory::where('status', 'success')->count(),
            'failed'  => BackupHistory::where('status', 'failed')->count(),
            'last'    => BackupHistory::where('status', 'success')->latest()->first(),
        ];

        return view('admin.backups.index', compact('backups', 'stats', 'search'));
    }

    public function create(): RedirectResponse
    {
        try {
            $history = $this->backups->runDatabaseBackup('manual', auth()->id());
            return back()->with('success', "Backup created: {$history->filename} ({$history->human_size})");
        } catch (\Throwable $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download(BackupHistory $backup): StreamedResponse
    {
        abort_unless($backup->existsOnDisk(), 404, 'Backup file missing.');

        return Storage::disk($backup->disk)->download($backup->path, $backup->filename);
    }

    public function restore(Request $request, BackupHistory $backup): RedirectResponse
    {
        $request->validate([
            'confirm' => ['required', 'in:RESTORE'],
        ]);

        if ($backup->status !== 'success') {
            return back()->with('error', 'Cannot restore from a failed/incomplete backup.');
        }

        try {
            $this->backups->restore($backup);
            return back()->with('success', 'Database restored successfully. Please verify data.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }

    public function destroy(BackupHistory $backup): RedirectResponse
    {
        if ($backup->existsOnDisk()) {
            Storage::disk($backup->disk)->delete($backup->path);
        }
        $backup->delete();

        return back()->with('success', 'Backup deleted.');
    }
}