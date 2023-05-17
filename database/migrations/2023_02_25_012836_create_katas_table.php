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
            $table->foreignId('challenge_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('owner_id')->constrained('profiles', 'id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('language_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('mode_id')->constrained()
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('uri_test')->unique();
            $table->string('signature');
            $table->string('testClassName');
            $table->timestamps();
            $table->unique(['challenge_id', 'language_id']);
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
