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
        Schema::table('books', function (Blueprint $table) {
            // 1. Rename or add 'summary' to match BookController
            if (!Schema::hasColumn('books', 'summary')) {
                $table->text('summary')->nullable()->after('isbn');
            }

            // 2. Only add 'cover_image' if it's not already in the original migration
            if (!Schema::hasColumn('books', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('summary');
            }

            // 3. Add location
            if (!Schema::hasColumn('books', 'location')) {
                $table->string('location')->nullable()->after('cover_image');
            }

            // 4. Add department (ensure it is NOT nullable if your Controller requires it)
            if (!Schema::hasColumn('books', 'department')) {
                $table->string('department')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['summary', 'cover_image', 'location', 'department']);
        });
    }
};