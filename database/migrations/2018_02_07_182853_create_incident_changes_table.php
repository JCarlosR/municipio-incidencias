<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_changes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type'); // registry, attention, derive, resolved, edit, open

            $table->integer('incident_id')->unsigned()->nullable();
            $table->foreign('incident_id')->references('id')->on('incidents');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('incident_changes');
    }
}
