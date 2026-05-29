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
        Schema::create('sub_racks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rack_id')->nullable();
            $table->foreign('rack_id')->references('id')->on('racks')->onDelete('set null');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_racks');
    }
};
