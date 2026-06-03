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
        Schema::create('ouvrier', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('metier_id')->references('id')
                ->on('metier')->onDelete('cascade');
            $table->foreignId('region_id')->references('id')
                ->on('region')->onDelete('cascade');
            $table->foreignId('country_id')->references('id')
                ->on('country')->onDelete('cascade');
            $table->foreignId('domain_id')->references('id')
                ->on('domain')->onDelete('cascade');
            $table->string('phone_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable(false);
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number_2')->nullable()->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_cni')->nullable();
            $table->string('numero_cni')->nullable();
            $table->foreignId('departement_id')->references('id')
                ->on('departement')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ouvrier');
    }
};
