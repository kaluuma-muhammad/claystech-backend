<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('revenue_name');
            $table->bigInteger('rent_amount');
            $table->bigInteger('sell_amount');
            $table->unsignedInteger('product');
            $table->unsignedInteger('added_by');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('product')->references('id')->on('products')->onDelete('set null');
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
        Schema::dropIfExists('revenues');
    }
}
