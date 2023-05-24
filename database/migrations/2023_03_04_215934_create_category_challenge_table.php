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
        Schema::create('category_challenge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('challenge_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique(['category_id', 'challenge_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_challenge');
    }
};
