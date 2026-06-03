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
        Schema::table('ouvrier', function (Blueprint $table) {
            $table->integer('annees_experience')->nullable();
            $table->string("entreprises")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ouvrier', function (Blueprint $table) {
            $table->dropColumn(['annees_experience', 'entreprises']);
        });
    }
};
