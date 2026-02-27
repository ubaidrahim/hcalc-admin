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
        Schema::table('calculators', function (Blueprint $table) {
            $table->json('related_calcs')->nullable()->after('subcategory_id');
            $table->string('component')->nullable()->after('related_calcs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calculators', function (Blueprint $table) {
            $table->dropColumn('related_calcs');
            $table->dropColumn('component');
        });
    }
};
