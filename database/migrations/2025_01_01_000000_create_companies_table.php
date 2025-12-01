<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subdomain')->unique(); // ex: gse, ies

            // Contrat / facturation
            $table->dateTime('contract_start_at')->nullable();
            $table->dateTime('contract_end_at')->nullable();
            $table->enum('billing_status', ['trial', 'active', 'unpaid', 'suspended'])
                  ->default('trial');
            $table->boolean('is_suspended')->default(false);

            // Modules activés (sms, factures, carte, etc.)
            $table->json('enabled_modules')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
