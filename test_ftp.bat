@echo off
:: ===================================================================
:: SCRIPT TEST KONEKSI SFTP/FTP CPANEL (WINSCP)
:: ===================================================================

:: --- KREDENSIAL ANDA ---
set SFTP_HOST=ftp.intisuksesdevelopment.my.id
set SFTP_PORT=21
set SFTP_USER=ftpreza
set SFTP_PASS=EzcYxdtVYgd524Dzpy6A
:: ----------------------------------------------

:: Auto-detect lokasi WinSCP di PC Lokal
if exist "C:\Program Files\xspeed\WinSCP\WinSCP.com" (
    set WINSCP_PATH="C:\Program Files\xspeed\WinSCP\WinSCP.com"
) else if exist "C:\Program Files (x86)\WinSCP\WinSCP.com" (
    set WINSCP_PATH="C:\Program Files (x86)\WinSCP\WinSCP.com"
) else if exist "C:\Program Files\WinSCP\WinSCP.com" (
    set WINSCP_PATH="C:\Program Files\WinSCP\WinSCP.com"
) else (
    echo [GAGAL] WinSCP.com tidak ditemukan di PC Anda!
    pause
    exit /b
)

echo ==================================================
echo  Mencoba Koneksi ke %SFTP_HOST% via SFTP...
echo ==================================================
echo.

:: Menjalankan WinSCP untuk cek koneksi dan list folder root
%WINSCP_PATH% /command ^
    "open sftp://%SFTP_USER%:%SFTP_PASS%@%SFTP_HOST%:%SFTP_PORT%/ -hostkey=*" ^
    "echo === KONEKSI BERHASIL! BERIKUT ISI FOLDER ROOT ANDA: ===" ^
    "ls" ^
    "exit"

echo.
echo ==================================================
if %ERRORLEVEL% EQU 0 (
    echo  [SUKSES] Tes koneksi dan perintah 'ls' berhasil!
) else (
    echo  [GAGAL] Koneksi ditolak atau error.
    echo  Silakan baca log di atas untuk melihat detail errornya.
)
echo ==================================================
pause
