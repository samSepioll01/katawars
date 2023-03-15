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
        Schema::create('scoreables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('scoreables');
            $table->foreignId('score_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique([
                'profile_id',
                'scoreables_type',
                'scoreables_id',
                'score_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scoreables');
    }
};
