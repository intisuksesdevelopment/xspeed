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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('icon');
            $table->string('path');
            $table->text('description')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
            $table->foreign('parent_id')->references('id')->on('menus');
        });
        Schema::create('user_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
