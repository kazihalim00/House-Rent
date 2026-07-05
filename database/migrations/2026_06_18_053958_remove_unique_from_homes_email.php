<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homes', function (Blueprint $table) {
            // Drop the unique index.
            $table->dropUnique('homes_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('homes', function (Blueprint $table) {
                $table->unique('email', 'homes_email_unique');
            });
        } catch (QueryException $e) {
            // Ignore duplicate-entry errors when recreating the unique index
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'Duplicate entry')) {
                return;
            }

            throw $e;
        }
    }
};
