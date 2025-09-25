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
        Schema::table('your_models', function (Blueprint $table) {
            $table->enum('profil', ['Administrateur', 'Utilisateur standard'])
                  ->default('Utilisateur standard')
                  ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('your_models', function (Blueprint $table) {
            $table->dropColumn('profil');
        });
    }
};