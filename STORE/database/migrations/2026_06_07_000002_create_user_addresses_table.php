<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_addresses')) {
            return;
        }

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('label', 80)->default('Home');
            $table->string('recipient_name', 120);
            $table->string('phone', 30);
            $table->text('address_line');
            $table->string('ward', 120)->nullable();
            $table->string('district', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('country', 80)->default('Vietnam');
            $table->string('postal_code', 30)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
