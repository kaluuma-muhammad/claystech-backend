<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->unsignedInteger('head_of_project');
            $table->string('project_type');
            $table->date('due_date');
            $table->integer('progress');
            $table->string('stage');
            $table->mediumText('project_details');
            $table->unsignedInteger('added_by');
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('head_of_project')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('projects');
    }
}
