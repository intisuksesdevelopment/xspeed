<?php
// Set permissions
function setPermissions($path, $permissions) {
    chmod($path, $permissions);
    if (is_dir($path)) {
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                setPermissions($path.'/'.$item, $permissions);
            }
        }
    }
}

setPermissions(__DIR__.'/storage', 0755);
setPermissions(__DIR__.'/bootstrap/cache', 0755);

// Generate key jika belum ada
if (!file_exists(__DIR__.'/.env')) {
    copy(__DIR__.'/.env.example', __DIR__.'/.env');
    file_put_contents(__DIR__.'/.env', "\nAPP_KEY=base64:".base64_encode(random_bytes(32)), FILE_APPEND);
}

echo "Setup completed! Please delete this file immediately!";
?>