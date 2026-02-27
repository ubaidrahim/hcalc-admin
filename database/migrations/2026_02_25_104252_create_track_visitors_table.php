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
        Schema::create('track_visitors', function (Blueprint $table) {
            $table->id();
            $table->integer('visitor_id');
            $table->string('event_type')->default('page_view');
            $table->text('url');
            $table->text('referrer')->nullable();
            $table->text('user_agent')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_visitors');
    }
};
