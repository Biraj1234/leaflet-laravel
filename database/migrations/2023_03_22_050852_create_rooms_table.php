<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
