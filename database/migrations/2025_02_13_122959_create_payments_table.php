<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id');
            $table->unsignedBigInteger('ref_id');
            $table->string('ref');
            $table->string('type');
            $table->text('desc')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('disc_percent', 5, 2)->default(0);
            $table->decimal('disc_total', 10, 2)->default(0);
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->decimal('tax_total', 10, 2)->default(0);
            $table->decimal('dp_total', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2);
            $table->decimal('payment_total', 10, 2);
            $table->unsignedBigInteger('payment_method_id');
            $table->json('payment_data')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('update_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('update_by')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
