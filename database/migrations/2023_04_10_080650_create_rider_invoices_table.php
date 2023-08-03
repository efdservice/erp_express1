<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('inv_date');
            $table->unsignedBigInteger('RID');
            $table->unsignedBigInteger('VID');
            $table->string('zone')->nullable();
            $table->bigInteger('login_hours')->nullable();
            $table->bigInteger('working_days')->nullable();
            $table->float('perfect_attendance')->nullable();
            $table->bigInteger('rejection')->nullable();
            $table->bigInteger('performance')->nullable();
            $table->bigInteger('off')->nullable();
            $table->integer('month_invoice')->nullable();
            $table->text('descriptions');
            $table->float('total_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rider_invoices');
    }
}
