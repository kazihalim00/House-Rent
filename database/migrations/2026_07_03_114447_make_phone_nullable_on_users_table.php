<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    DB::statement("ALTER TABLE `users` MODIFY `phone` VARCHAR(255) NULL");
    }
    public function down(): void
    {
    DB::statement("ALTER TABLE `users` MODIFY `phone` VARCHAR(255) NOT NULL");
    }
};
