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
        Schema::create('smtp', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('domain');
            $table->unsignedBigInteger('usage')->default(0);
            $table->unsignedBigInteger('max_number')->default(0); // Assuming '0' means unlimited
            $table->string('alert');
            $table->string('status');
            $table->timestamps(); // This will create both created_at and updated_at columns
            $table->timestamp('expires_at')->nullable(); // Assuming this can be nullable
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp');
    }
};
