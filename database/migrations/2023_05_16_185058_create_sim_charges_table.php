<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_charges', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date');
            $table->date('post_date');
            $table->unsignedBigInteger('sim_id');
            $table->unsignedBigInteger('CID');
            $table->float('amount');
            $table->text('attached_doc')->nullable();
            $table->text('other_details')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->bigInteger('trans_code');
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
        Schema::dropIfExists('sim_charges');
    }
}
