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
        Schema::create('kataway_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kataway_id')->constrained('kataways', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('profile_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->timestamp('end_date')->nullable();
            $table->unique(['kataway_id', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kataway_profile');
    }
};
