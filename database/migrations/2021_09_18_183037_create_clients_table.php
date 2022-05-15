<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_names');
            $table->string('client_email')->unique();
            $table->unsignedInteger('phone_code');
            $table->integer('client_contact');
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
        Schema::dropIfExists('clients');
    }
}
