<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('global');
            // When parent is deleted so are children - whole way down family tree
            $table->foreignId('parent_id')->nullable()->references('id')->on('tags')->onDelete('cascade');
            $table->string('colour');
            // translucent version of tag colour for balancer suggestion
            $table->string('suggested');
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
        Schema::dropIfExists('tags');
    }
}
