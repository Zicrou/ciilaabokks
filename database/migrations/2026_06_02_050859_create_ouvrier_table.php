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
        Schema::create('ouvriers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            
            $table->uuid('region_id');
            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('cascade');
            $table->uuid('country_id');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
            $table->uuid('departement_id');
            $table->foreign('departement_id')
                ->references('id')
                ->on('departements')
                ->onDelete('cascade');
            $table->string('phone_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable(false);
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number_2')->nullable()->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_cni')->nullable();
            $table->string('numero_cni')->nullable();
            $table->integer('annees_experience')->nullable();
            $table->string("entreprises")->nullable();
            // $table->uuid('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvriers');
    }
};
