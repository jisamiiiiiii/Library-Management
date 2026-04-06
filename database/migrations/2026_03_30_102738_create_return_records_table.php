<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('return_records', function (Blueprint $table) {
            $table->id(); 
            

            $table->foreignId('borrow_id')->constrained('borrow_records')->onDelete('cascade');
            
     
            $table->date('return_date');
            

            $table->decimal('penalty_amount', 8, 2)->default(0.00);
            

            $table->enum('status', ['pending', 'paid'])->default('pending');
            
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('return_records');
    }
};