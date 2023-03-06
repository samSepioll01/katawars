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
        Schema::create('likeable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->morphs('likeable');
            $table->timestamps();
            $table->unique(['likeable_id', 'likeable_type', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likeable');
    }
};
