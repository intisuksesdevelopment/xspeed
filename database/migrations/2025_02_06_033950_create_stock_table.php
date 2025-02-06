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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('periode');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('total_item');
            $table->float('stock_total');
            $table->float('qty_total');
            $table->float('diff_total');
            $table->float('diff_price_total');
            $table->float('price_total');
            $table->string('approve_by');
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username of the user who created the record');
            $table->string('updated_by')->nullable()->comment('username of the user who last updated the record');
            $table->integer('status')->default(0)->comment('0=success;1=rejected;2=waiting;');

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
        Schema::create('stock_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('item_id');
            $table->float('item_stock');
            $table->float('item_price');
            $table->string('rack');
            $table->integer('qty');
            $table->float('diff');
            $table->float('price_total');
            $table->timestamps();
            $table->string('created_by')->nullable()->comment('username of the user who created the record');
            $table->string('updated_by')->nullable()->comment('username of the user who last updated the record');
            $table->integer('status')->default(0)->comment('0=active;1=deleted;');

            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_data');
        Schema::dropIfExists('stocks');
    }
};
