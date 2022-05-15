<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('email')->unique();
            $table->unsignedInteger('phone_code');
            $table->integer('contact');
            $table->string('image');
            $table->integer('salary');
            $table->string('n_i_d');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('role_post');
            $table->unsignedInteger('country_id');
            $table->string('address');
            $table->date('contract_start');
            $table->date('contract_end');
            $table->string('gender');
            $table->unsignedInteger('added_by');
            $table->string('status')->default(1);
            $table->timestamps();
            $table->foreign('phone_code')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('department')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('role_post')->references('id')->on('posts')->onDelete('set null');
            $table->foreign('country')->references('id')->on('countries')->onDelete('set null');
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
        Schema::dropIfExists('employees');
    }
}
