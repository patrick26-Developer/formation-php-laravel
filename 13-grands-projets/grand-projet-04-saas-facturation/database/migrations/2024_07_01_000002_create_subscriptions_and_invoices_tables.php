<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->restrictOnDelete();
            $table->string('statut')->default('active'); // active | annulee
            $table->timestamp('debut_periode');
            $table->timestamp('fin_periode');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant', 8, 2);
            $table->string('statut')->default('impayee'); // impayee | payee
            $table->timestamp('emise_le');
            $table->timestamp('payee_le')->nullable();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('nom');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('subscriptions');
    }
};
