<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class FileController extends Controller
{
    public function create()
    {
        return view('pages.layout.partials.upload');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:2048',
            ]);
            // Debug the Google Drive disk configuration
            $googleDriveConfig = Config::get('filesystems.disks.google');



            $file = $request->file('file');
            Gdrive::put('/filename.jpg', $file);
            return response()->json([
                'success' => true,
                'message' => 'File berhasil di-upload ke Google Drive!',
                'file_path' => $filePath
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading file to Google Drive: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat meng-upload file: ' . $e->getMessage()
            ], 500);
        }
    }
}
