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
        Schema::create('ip_group', function (Blueprint $table) {
            $table->id('ip_group_id');
            $table->string('ip_name');
        });

        Schema::create('household', function (Blueprint $table) {
            $table->id('household_id');
            $table->integer('no_members')->default(0);
            $table->string('address')->nullable();
        });


        Schema::create('family', function (Blueprint $table) {
            $table->id('family_id');
            $table->integer('no_members')->default(0);
            $table->foreignId('household_id')->constrained('household','household_id')->onDelete('cascade');
        });


        Schema::create('individual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->constrained('household', 'household_id')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('family', 'family_id')->onDelete('cascade');
            $table->foreignId('ip_group_id')->constrained('ip_group', 'ip_group_id')->onDelete('cascade');
            $table->enum('family_role', ['wife', 'husband', 'daughter', 'son', 'other']);
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('ext')->nullable();
            $table->date('dob')->nullable();
            $table->string('contactno')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['male', 'female', 'not_specified'])->default('not_specified');
            $table->boolean('is_half_blooded')->default(false);
        });


        Schema::create('household_head', function (Blueprint $table) {
            $table->id('household_head_id');
            $table->foreignId('household_id')->constrained('household', 'household_id')->onDelete('cascade');
            $table->foreignId('individual_id')->constrained('individual')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual');
        Schema::dropIfExists('family');
        Schema::dropIfExists('household');
        Schema::dropIfExists('ip_group');
        Schema::dropIfExists('household_head');
    }
};
