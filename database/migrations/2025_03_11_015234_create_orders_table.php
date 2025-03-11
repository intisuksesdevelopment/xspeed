<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('trx_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_position')->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('name')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->decimal('tax_percent', 8, 2)->nullable();
            $table->decimal('tax_total', 15, 2)->nullable();
            $table->decimal('disc_percent', 8, 2)->nullable();
            $table->decimal('disc_total', 15, 2)->nullable();
            $table->decimal('dp_total', 15, 2)->nullable();
            $table->decimal('up_total', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('sub_total_item', 15, 2)->nullable();
            $table->decimal('final_total', 15, 2)->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->json('payment_data')->nullable();
            $table->date('expired_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps(); // Adds `created_at` and `updated_at`
            $table->timestamp('process_at')->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->string('created_by')->nullable();
            $table->string('process_by')->nullable();
            $table->string('confirm_by')->nullable();
            $table->string('update_by')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};