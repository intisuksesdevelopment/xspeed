<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDataTable extends Migration
{
    public function up()
    {
        Schema::create('sales_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid');
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('item_id');
            $table->string('item_code');
            $table->text('item_desc')->nullable();
            $table->string('item_name');
            $table->integer('item_amount');
            $table->integer('item_amount_received')->nullable();
            $table->string('item_unit');
            $table->decimal('item_price', 10, 2);
            $table->decimal('item_disc', 10, 2)->default(0);
            $table->decimal('item_disc_total', 10, 2)->default(0);
            $table->decimal('item_total', 10, 2);
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('sent_date')->nullable();
            $table->timestamp('update_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('update_by')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_data');
    }
}
