<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); 
            

            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique(); 
            

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->enum('status', ['available', 'borrowed', 'lost'])->default('available');
            // ----------------------------------
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};