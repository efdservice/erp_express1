<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignVendorRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_vendor_riders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('VID');
            $table->unsignedBigInteger('RID');
            $table->unique(['VId','RID']);
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
        Schema::dropIfExists('assign_vendor_riders');
    }
}
