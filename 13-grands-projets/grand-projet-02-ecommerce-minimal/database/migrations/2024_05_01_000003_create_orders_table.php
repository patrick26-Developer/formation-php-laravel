<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('statut')->default('en_attente'); // en_attente | payee | echouee
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            // Prix et nom COPIÉS au moment de la commande (dénormalisation
            // volontaire) : si le produit change de prix ou est supprimé
            // plus tard, l'historique de la commande reste exact.
            $table->string('nom_produit');
            $table->decimal('prix_unitaire', 10, 2);
            $table->unsignedInteger('quantite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
