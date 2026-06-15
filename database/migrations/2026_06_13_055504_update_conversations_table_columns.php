<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->renameColumn('tenant_id', 'user_one_id');
            $table->renameColumn('owner_id', 'user_two_id');
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->renameColumn('user_one_id', 'tenant_id');
            $table->renameColumn('user_two_id', 'owner_id');
        });
    }
};