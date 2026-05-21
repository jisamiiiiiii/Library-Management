<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            // This makes the old column optional so it doesn't crash your seeders
            $table->timestamp('borrowed_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->timestamp('borrowed_date')->nullable(false)->change();
        });
    }
};