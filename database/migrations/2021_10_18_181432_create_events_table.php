<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("tag_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("commitment_id")->nullable()->constrained()->onDelete("cascade");
            // time can be null if set to all day
            $table->string("start_time")->nullable();
            $table->string("end_time")->nullable();
            $table->string("start_date");
            $table->string("end_date")->nullable();
            $table->boolean("all_day");
            $table->boolean("isolated");
            $table->boolean("suggested")->default(0);
            $table->longText("notes")->nullable();
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
        Schema::dropIfExists('events');
    }
}
