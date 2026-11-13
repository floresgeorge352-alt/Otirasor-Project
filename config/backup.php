<?php

return [
    // Full path sa XAMPP MySQL binaries (Windows)
    'mysql_dump_path' => env('MYSQL_DUMP_PATH', 'C:\\xampp\\mysql\\bin\\mysqldump.exe'),
    'mysql_path'      => env('MYSQL_PATH', 'C:\\xampp\\mysql\\bin\\mysql.exe'),

    // Retention: ilang araw bago auto-delete ang lumang backup
    'keep_days' => env('BACKUP_KEEP_DAYS', 30),

    // Disk kung saan ise-save (storage/app/)
    'disk' => 'local',
];