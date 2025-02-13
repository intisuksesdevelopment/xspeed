<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id');
            $table->string('type');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->decimal('tax_total', 10, 2)->default(0);
            $table->decimal('disc_percent', 5, 2)->default(0);
            $table->decimal('disc_total', 10, 2)->default(0);
            $table->decimal('dp_total', 10, 2)->default(0);
            $table->decimal('up_total', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2);
            $table->json('charge_data')->nullable();
            $table->decimal('charge_total', 10, 2)->default(0);
            $table->decimal('sub_total_item', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2);
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->json('payment_data')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->decimal('payment_change', 10, 2)->default(0);
            $table->decimal('payment_remaining', 10, 2)->default(0);
            $table->integer('payment_status')->default(0)->comment('0=paid;1=unpaid;2=hold;3=other');
            $table->string('currency');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('process_date')->nullable();
            $table->timestamp('update_date')->nullable();
            $table->timestamp('confirm_date')->nullable();
            $table->string('created_by')->nullable();
            $table->string('process_by')->nullable();
            $table->string('confirm_by')->nullable();
            $table->string('update_by')->nullable();
            $table->integer('status')->default(0)->comment('0=success;1=deleted;2=waiting;');
            $table->unsignedBigInteger('cust_id')->nullable();
            $table->string('cust_address')->nullable();
            $table->string('cust_phone')->nullable();
            $table->string('cust_name')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
