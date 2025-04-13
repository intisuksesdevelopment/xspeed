<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class DataImport implements ToCollection, WithCalculatedFormulas
{
    public function collection(Collection $rows)
    {
        if ($rows[0][25] == 'template-product') {
            return $this->processProduct($rows);
        } else {
            \Log::info("BUKAN");

        }

    }
    public function processProduct($rows)
    {
        \Log::info("processProduct " . $rows[0][25]);

        //ROW START AT B5 or Index 4
        $subsetRows = array_slice($rows, 4);

        foreach ($subsetRows as $row) {
            if ($row[1]!=null && $row[1] != '') {
                $item = new Item();
                $headerRow = $this->getHeaderRow($row);
                break; // Hentikan iterasi setelah menemukan kondisi
            }
        }
        return 1; // Menentukan baris mana yang berisi header
    }
}
