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
        Schema::create('punctuables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('punctuables');
            $table->foreignId('punctuation_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique([
                'profile_id',
                'punctuables_type',
                'punctuables_id',
                'punctuation_id',
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
        Schema::dropIfExists('punctuables');
    }
};
