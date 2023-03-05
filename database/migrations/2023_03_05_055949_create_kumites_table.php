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
        Schema::create('kumites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kata_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('opponent_id')->constrained('profiles', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('winner_id')->constrained('profiles', 'id');
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
        Schema::dropIfExists('kumites');
    }
};
