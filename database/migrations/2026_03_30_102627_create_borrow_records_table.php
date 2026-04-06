<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('borrow_records', function (Blueprint $table) {
            $table->id();
            

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            
            $table->unsignedBigInteger('librarian_id');
            $table->foreign('librarian_id')->references('id')->on('users');

            $table->date('borrow_date');
            $table->date('due_date');

            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};