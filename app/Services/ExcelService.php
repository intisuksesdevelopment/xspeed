<?php

namespace App\Services;

use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExcelService
{
    public static function import($file, $importer)
    {
        // Validasi file
        if (!$file->isValid()) {
            throw new \Exception('File tidak valid');
        }
        $currentDate = date('Y-m-d');
        $fileName = $file->getClientOriginalName().'_' . $currentDate; 
        $destinationPath = 'uploads/' . $fileName;

        if (Storage::exists($destinationPath)) {
            Storage::delete($destinationPath); 
        }
        $filePath = $file->storeAs('uploads', $fileName);

        // Proses impor file dengan importer
        try {
            Excel::import(new DataImport, $file);
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Kesalahan saat mengimpor file: " . $e->getMessage());
        }
    }
}