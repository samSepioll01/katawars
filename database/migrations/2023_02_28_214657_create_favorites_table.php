<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    *   This table is used to control whether the solutions
    *   have ever been marked as favorites.
    *   It also helps to take control over distributed honor points.
    */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('solution_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_active');
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
