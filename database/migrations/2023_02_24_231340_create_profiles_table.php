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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('slug')->unique();
            $table->bigInteger('exp');
            $table->bigInteger('honor');
            $table->boolean('is_darkmode');
            $table->boolean('is_deleted');
            $table->boolean('is_banned');
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
        Schema::dropIfExists('profiles');
    }
};
