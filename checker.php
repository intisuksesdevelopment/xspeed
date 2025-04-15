<?php
// Laravel Folder Permission Checker
// Simpan sebagai check-permission.php di root folder Laravel, lalu akses via browser

// Security precaution
if (!isset($_SERVER['HTTP_HOST']) || $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    die('Akses ditolak! File ini hanya untuk pemeriksaan internal.');
}

echo "<h2>Laravel Folder Permission Checker</h2>";
echo "<style>body{font-family: Arial; line-height: 1.6;} .ok{color:green;} .warn{color:orange;} .error{color:red;}</style>";

// Daftar folder penting yang perlu diperiksa
$criticalFolders = [
    '/',
    '/storage',
    '/storage/app',
    '/storage/framework',
    '/storage/framework/cache',
    '/storage/framework/sessions',
    '/storage/framework/views',
    '/storage/logs',
    '/bootstrap/cache',
    '/public',
];

// Fungsi untuk mengecek permission
function checkPermission($path) {
    $fullPath = __DIR__ . $path;
    
    if (!file_exists($fullPath)) {
        return ['status' => 'error', 'message' => 'Tidak ditemukan'];
    }
    
    $permission = substr(sprintf('%o', fileperms($fullPath)), -3);
    $writable = is_writable($fullPath);
    
    $status = ($writable && ($permission === '755' || $permission === '775')) 
        ? 'ok' 
        : ($writable ? 'warn' : 'error');
    
    return [
        'status' => $status,
        'permission' => $permission,
        'writable' => $writable ? 'Ya' : 'Tidak'
    ];
}

// Tabel hasil pemeriksaan
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Folder</th><th>Permission</th><th>Writeable</th><th>Status</th></tr>";

foreach ($criticalFolders as $folder) {
    $result = checkPermission($folder);
    echo "<tr>";
    echo "<td>$folder</td>";
    echo "<td>{$result['permission']}</td>";
    echo "<td>{$result['writable']}</td>";
    echo "<td class='{$result['status']}'>";
    echo match($result['status']) {
        'ok' => '✔ Ideal',
        'warn' => '⚠ Bisa bekerja tapi kurang ideal',
        'error' => '✖ Bermasalah'
    };
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

// Rekomendasi
echo "<h3>Rekomendasi:</h3>";
echo "<ul>";
echo "<li>Permission ideal untuk folder: <strong>755</strong> (atau 775 jika perlu)</li>";
echo "<li>Permission file: <strong>644</strong></li>";
echo "<li>Folder <code>storage</code> dan <code>bootstrap/cache</code> harus writable</li>";
echo "</ul>";

echo "<p><strong>Catatan:</strong> Hapus file ini setelah selesai pemeriksaan!</p>";
?>