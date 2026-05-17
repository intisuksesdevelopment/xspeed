<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('bank_id'); // FK to banks table
            $table->string('owner_type'); // 'store' or 'supplier'
            $table->unsignedBigInteger('owner_id')->nullable(); // supplier_id if owner_type = 'supplier', null if store
            $table->string('account_number', 50);
            $table->string('account_name', 100);
            $table->string('branch')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0); // 0=active, 1=inactive
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('bank_id');
            $table->index(['owner_type', 'owner_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
