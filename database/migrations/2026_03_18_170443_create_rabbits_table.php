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
        Schema::create('rabbits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('name');
            $table->string('tattoo_id')->unique();
            $table->enum('sex', ['buck', 'doe']);
            // Self-referencing keys for the pedigree tree
            $table->foreignId('sire_id')->nullable()->constrained('rabbits');
            $table->foreignId('dam_id')->nullable()->constrained('rabbits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rabbits');
    }
};
