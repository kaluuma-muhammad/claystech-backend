<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->bigInteger('salary');
            $table->string('payment_method');
            $table->string('account_num')->nullable();
            $table->bigInteger('paid_amount');
            $table->bigInteger('balance');
            $table->unsignedInteger('recorded_by');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
