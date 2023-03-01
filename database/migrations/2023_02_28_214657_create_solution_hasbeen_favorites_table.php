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
        Schema::create('solution_hasbeen_favorite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('solution_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique(['profile_id', 'solution_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};
