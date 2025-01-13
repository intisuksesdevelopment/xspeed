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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });

        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('account_number');
            $table->integer('type')->comment('0=company;1=supplier;2=user;3=buyer')->default(0);
            $table->text('description')->nullable();
            $table->integer('is_primary')->comment('0=primary;1=not_primary;')->default(0);
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('code');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('sub_district');
            $table->string('npwp');
            $table->decimal('discount', 10, 2);
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->integer('type')->comment('0=item;1=sales;2=order;3=payable;4=receivable')->default(0);
            $table->text('description')->nullable();
            $table->string('img_id')->nullable();
            $table->string('path')->nullable();
            $table->string('ext')->nullable();
            $table->string('source')->comment('0=local;1=gdrive;')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->integer('index')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('rack');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('warehouse');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('suppliers');

    }
};
