<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commitments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("tag_id")->constrained()->onCascade("delete");
            $table->string("occurance");
            $table->string("day")->nullable();
            $table->timestamp("start_time");
            $table->timestamp("end_time");
            $table->timestamp("start_date");
            $table->timestamp("end_date");
            $table->longText("notes");
            // $table->foreignId("checklist_id")->constrained();
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
        Schema::dropIfExists('commitments');
    }
}
