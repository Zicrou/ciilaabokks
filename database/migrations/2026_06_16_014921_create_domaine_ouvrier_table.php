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
        Schema::create('domaine_ouvrier', function (Blueprint $table) {
            $table->uuid('ouvrier_id');
            $table->foreign('ouvrier_id')
                ->references('id')
                ->on('ouvriers')
                ->onDelete('cascade');
            $table->uuid('domaine_id');
            $table->foreign('domaine_id')
                ->references('id')
                ->on('domaines')
                ->onDelete('cascade');
                
            $table->primary(['ouvrier_id', 'domaine_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domaine_ouvrier');
    }
};
