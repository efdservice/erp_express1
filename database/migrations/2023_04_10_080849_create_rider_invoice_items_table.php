<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->integer('qty');
            $table->float('rate')->default(0);
            $table->float('discount')->default(0);
            $table->float('tax')->default(0);
            $table->float('amount');
            $table->timestamps();
            $table->unsignedBigInteger('inv_id');
            $table->foreign('inv_id')->references('id')->on('rider_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rider_invoice_items');
    }
}
