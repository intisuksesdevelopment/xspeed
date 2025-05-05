<?php
// Path ke file ZIP dan folder tujuan ekstraksi
$zipFile = 'vendor.zip'; // Nama file ZIP
$extractTo = 'vendor/'; // Direktori tujuan ekstraksi

// Periksa apakah file ZIP ada
if (!file_exists($zipFile)) {
    die("Error: File $zipFile tidak ditemukan.");
}

// Inisialisasi class ZipArchive
$zip = new ZipArchive;

// Buka file ZIP
if ($zip->open($zipFile) === TRUE) {
    // Ekstrak ke folder tujuan
    if ($zip->extractTo($extractTo)) {
        echo "File berhasil diekstrak ke folder $extractTo.";
    } else {
        echo "Gagal mengekstrak file.";
    }
    // Tutup file ZIP
    $zip->close();
} else {
    echo "Gagal membuka file ZIP.";
}
?>