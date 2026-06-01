@echo off
:: ===================================================================
:: SCRIPT ZIP LARAVEL MENGGUNAKAN WINRAR (FIXED)
:: ===================================================================

:: Tentukan folder tujuan
set TARGET_DIR=D:\xspeed\release\

:: Membuat folder tujuan jika belum ada
if not exist "%TARGET_DIR%" (
    echo Membuat folder tujuan: %TARGET_DIR%
    mkdir "%TARGET_DIR%"
)

:: Mengambil komponen Tanggal dan Waktu (Format: YYYYMMDDHHMMSS.mmm)
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I

:: Memotong string datetime menjadi format: YYYYMMDD-HHMMSSmmm
set FILE_NAME=%datetime:~0,8%-%datetime:~8,6%%datetime:~15,3%.zip
set ZIP_PATH=%TARGET_DIR%%FILE_NAME%

:: Menggunakan WinRAR.exe (bukan rar.exe) agar mendukung format ZIP
set WINRAR_PATH="C:\Program Files\WinRAR\WinRAR.exe"

echo --------------------------------------------------
echo  Memulai proses kompresi Laravel (WinRAR)...
echo  Lokasi Simpan: %ZIP_PATH%
echo --------------------------------------------------

:: Membuat file list exclude untuk WinRAR
echo node_modules> exclude.txt
echo vendor>> exclude.txt
echo .git>> exclude.txt
echo .claude>> exclude.txt
echo .github>> exclude.txt
echo .vscode>> exclude.txt
echo .env>> exclude.txt
echo zip_laravel.bat>> exclude.txt
echo deploy.bat>> exclude.txt
echo exclude.txt>> exclude.txt
echo storage\framework\cache\data\*>> exclude.txt
echo storage\framework\sessions\*>> exclude.txt
echo storage\framework\views\*>> exclude.txt
echo storage\logs\*>> exclude.txt

:: Jalankan perintah WinRAR
:: a     : perintah add
:: -ibck : menjalankan proses di background (tanpa pop-up mengganggu)
:: -r    : rekursif ke dalam folder
:: -x@   : membaca daftar exclude
%WINRAR_PATH% a -ibck -r -x@exclude.txt "%ZIP_PATH%" *

:: Hapus file exclude sementara
del exclude.txt

echo --------------------------------------------------
if %ERRORLEVEL% EQU 0 (
    echo  [SUKSES] File berhasil dikompres ke: %ZIP_PATH%
) else (
    echo  [GAGAL] Terjadi kesalahan saat kompresi. Periksa apakah WinRAR terinstal.
)
echo --------------------------------------------------
pause
