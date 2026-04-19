<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks to prevent issues when dropping tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Retrieve all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Drop each table
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            if ($tableName != 'migrations') {
                Schema::dropIfExists($tableName);
            } else {
                DB::table('migrations')->truncate();
            }
        }

        // Enable foreign key checks back
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // There is no straightforward way to recreate all dropped tables
        // You can leave this method empty or implement specific logic as needed
    }
};
