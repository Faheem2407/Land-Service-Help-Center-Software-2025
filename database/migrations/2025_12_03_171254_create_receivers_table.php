<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();

            $table->date('date');

            $table->string('si_no')->nullable();
            $table->string('receipt_no')->nullable();

            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->string('receiver_name', 200);
            $table->string('mobile', 20)->nullable();
            $table->string('village', 200)->nullable();
            $table->string('mouza_name', 200)->nullable();   
            $table->string('khatian_no', 100)->nullable();  

            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('sub_district_id')->nullable()->constrained('sub_districts')->nullOnDelete();

            $table->string('nid_no', 50)->nullable();
            $table->string('tracking_no', 100)->nullable();

            $table->foreignId('helper_id')->constrained('helpers')->cascadeOnDelete();

            $table->decimal('processing_charge', 10, 2);
            $table->decimal('online_charge', 10, 2);
            $table->decimal('total_charge', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};
