<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('meta_description')->nullable();
            $table->string('meta_robots')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('is_active')->default(false);
            $table->dateTime('publish_date')->nullable();
            $table->text('content');
            //$table->unsignedInteger('author_id');
            $table->timestamps();

            $table->foreignId('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
