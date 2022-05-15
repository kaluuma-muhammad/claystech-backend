<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('depart_name');
            $table->string('depart_email')->unique();
            $table->unsignedInteger('phone_code');
            $table->integer('depart_contact');
            $table->unsignedInteger('head_of_dapart');
            $table->unsignedInteger('added_by');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->foreign('phone_code')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('head_of_dapart')->references('id')->on('users')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
