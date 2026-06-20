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
        Schema::create('entreprise_ouvrier', function (Blueprint $table) {
        $table->uuid('ouvrier_id');
            $table->foreign('ouvrier_id')
            ->references('id')
            ->on('ouvriers')
            ->onDelete('cascade');
            $table->uuid('entreprise_id');
            $table->foreign('entreprise_id')
            ->references('id')
            ->on('entreprises')
            ->onDelete('cascade');
            $table->primary(['ouvrier_id', 'entreprise_id']);
            $table->timestamps();
        });

        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
