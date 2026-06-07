<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('order_status_histories')) {
            return;
        }

        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('from_status', 40)->nullable();
            $table->string('to_status', 40);
            $table->text('note')->nullable();
            $table->string('changed_by_name', 120)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
