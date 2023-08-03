<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('rider_id');
            $table->string('personal_contact');
            $table->string('company_contact');
            $table->string('personal_email');
            $table->string('email');
            $table->unsignedBigInteger('nationality');
            $table->string('NFDID')->nullable();
            $table->string('cdm_deposit_id')->nullable();
            $table->date('doj')->nullable()->comment('date of joining');
            $table->string('emirate_hub')->nullable();
            $table->string('emirate_id')->nullable();
            $table->date('emirate_exp')->nullable()->comment('emirated id expirty');
            $table->string('mashreq_id')->nullable();
            $table->string('passport')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->unsignedBigInteger('PID')->nullable();
            $table->string('DEPT')->nullable();
            $table->string('ethnicity')->nullable();
            $table->date('dob')->nullable();
            $table->string('license_no')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('visa_status')->nullable();
            $table->string('branded_plate_no')->nullable();
            $table->enum('vaccine_status',[0,1])->default(0);
            $table->json('attach_documents')->nullable();
            $table->text('other_details');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unique(['rider_id']);
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
        Schema::dropIfExists('riders');
    }
}
