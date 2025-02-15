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
            $table->foreignId("tag_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("occurance");
            $table->string("day")->nullable();
            // time can be null if set to all day
            $table->string("start_time")->nullable();
            $table->string("end_time")->nullable();
            $table->boolean("all_day");
            $table->string("start_date");
            $table->string("end_date");
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
