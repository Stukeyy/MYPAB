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
            // When ancestor or parent are deleted so are children - whole way down family tree
            $table->foreignId('ancestor_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreignId('parent_id')->references('id')->on('tags')->onDelete('cascade');
            // Amount of generations tag is a parent of
            $table->integer('descendants')->nullable();
            // Level in family tree from ancestor
            $table->integer('generation');
            $table->string('colour');
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
