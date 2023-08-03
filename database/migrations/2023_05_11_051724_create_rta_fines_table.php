<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRtaFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rta_fines', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date');
            $table->date('posting_date');
            $table->unsignedBigInteger('BID')->comment('bike id');
            $table->unsignedBigInteger('RID');
            $table->unsignedBigInteger('LCID');
            $table->string('toll_gate')->nullable();
            $table->date('trip_date')->nullable();
            $table->time('trip_time')->nullable();
            $table->string('direction')->nullable();
            $table->float('amount');
            $table->text('other_details');
            $table->text('attached_doc');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('rta_fines');
    }
}
