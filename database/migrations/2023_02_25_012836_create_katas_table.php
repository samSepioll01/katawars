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
        Schema::create('katas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('owner_id')->constrained('profiles', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mode_id')->constrained('modes', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('language_id')->constrained('languages', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('rank_id')->constrained('ranks', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('katas');
    }
};
