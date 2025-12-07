<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receiver_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiver_id')->constrained('receivers')->cascadeOnDelete();
            $table->string('file_path', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receiver_files');
    }
};
