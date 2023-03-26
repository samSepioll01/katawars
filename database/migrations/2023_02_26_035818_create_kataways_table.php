<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kataways', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('uri_image')->unique();
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
        Schema::dropIfExists('kataways');
    }
};
