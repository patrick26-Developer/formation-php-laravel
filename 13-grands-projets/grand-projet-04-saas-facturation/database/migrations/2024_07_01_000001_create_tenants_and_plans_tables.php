<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Gratuit, Pro, Entreprise
            $table->decimal('prix_mensuel', 8, 2);
            $table->unsignedInteger('limite_projets'); // 0 = illimité
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->dropConstrainedForeignId('tenant_id'));
        Schema::dropIfExists('plans');
        Schema::dropIfExists('tenants');
    }
};
