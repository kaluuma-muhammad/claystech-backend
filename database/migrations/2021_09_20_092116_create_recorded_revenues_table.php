<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordedRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recorded_revenues', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('revenue_id');
            $table->unsignedInteger('client_id');
            $table->string('revenue_type');
            $table->bigInteger('total_amount');
            $table->date('rent_from')->nullable();
            $table->date('rent_to')->nullable();
            $table->integer('period')->nullable();
            $table->bigInteger('paid_amount');
            $table->bigInteger('balance');
            $table->unsignedInteger('recorded_by');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('revenue')->references('id')->on('revenues')->onDelete('set null');
            $table->foreign('client')->references('id')->on('clients')->onDelete('set null');
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
        Schema::dropIfExists('recorded_revenues');
    }
}
