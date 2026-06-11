<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'UI/UX Designer', 'Project Manager']);
            $table->string('image');
            $table->string('short_bio');
            $table->string('github');
            $table->string('linkedin');
            $table->string('portfolio');
            $table->integer('order');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
