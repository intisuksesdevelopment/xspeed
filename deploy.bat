@echo off
:: ===================================================================
:: SCRIPT ZIP LARAVEL + AUTOMATIC UPLOAD FTP (WINSCP)
:: ===================================================================

:: --- KONFIGURASI FTP CPANEL ---
set FTP_HOST=ftp.intisuksesdevelopment.my.id
set FTP_PORT=21
set FTP_USER=ftpreza
set FTP_PASS=EzcYxdtVYgd524Dzpy6A
set REMOTE_DIR=/
:: ----------------------------------------------

:: Tentukan folder tujuan lokal
set TARGET_DIR=D:\xspeed\release\

:: Membuat folder tujuan jika belum ada
if not exist "%TARGET_DIR%" (
    mkdir "%TARGET_DIR%"
)

:: Mengambil komponen Tanggal dan Waktu
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set FILE_NAME=%datetime:~0,8%-%datetime:~8,6%%datetime:~15,3%.zip
set ZIP_PATH=%TARGET_DIR%%FILE_NAME%

:: Path Eksekusi WinRAR
set WINRAR_PATH="C:\Program Files\WinRAR\WinRAR.exe"

:: === SILAKAN PASANG PATH WINSCP ANDA DI SINI ===
:: Contoh jika ada di folder default Program Files:
if exist "C:\Program Files (x86)\WinSCP\WinSCP.com" (
    set WINSCP_PATH="C:\Program Files (x86)\WinSCP\WinSCP.com"
) else if exist "C:\Program Files\WinSCP\WinSCP.com" (
    set WINSCP_PATH="C:\Program Files\WinSCP\WinSCP.com"
) else (
    :: JIKA ANDA MENGGUNAKAN CUSTOM PATH, UNCOMMENT & EDIT BARIS DI BAWAH INI:
    :: set WINSCP_PATH="D:\WinSCP\WinSCP.com"

    echo [GAGAL] WinSCP.com tidak ditemukan! Silakan edit path di dalam script.
    pause
    exit /b
)
:: =================================================================

echo --------------------------------------------------
echo  1. Memulai Proses Kompresi Laravel (WinRAR)...
echo --------------------------------------------------

:: Membuat file list exclude
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

:: Jalankan WinRAR
%WINRAR_PATH% a -ibck -r -x@exclude.txt "%ZIP_PATH%" *
del exclude.txt

if %ERRORLEVEL% NEQ 0 (
    echo [GAGAL] Proses kompresi gagal. Upload dibatalkan.
    pause
    exit /b
)
echo [SUKSES] File berhasil dikompres: %FILE_NAME%

echo.
echo --------------------------------------------------
echo  2. Memulai Upload via FTP ke cPanel...
echo --------------------------------------------------

:: Menjalankan WinSCP untuk Upload via FTP
:: -passive=on : Menggunakan mode pasif agar aman dari blokir firewall lokal
%WINSCP_PATH% /command ^
    "open ftp://%FTP_USER%:%FTP_PASS%@%FTP_HOST%:%FTP_PORT%/ -passive=on" ^
    "mkdir -nofail %REMOTE_DIR%" ^
    "cd %REMOTE_DIR%" ^
    "put ""%ZIP_PATH%""" ^
    "exit"

echo --------------------------------------------------
if %ERRORLEVEL% EQU 0 (
    echo  [SUKSES] File %FILE_NAME%
    echo  telah aman mendarat di cPanel (%REMOTE_DIR%)
) else (
    echo  [GAGAL] Upload via FTP bermasalah. Periksa koneksi/kredensial/path WinSCP.
)
echo --------------------------------------------------
pause
