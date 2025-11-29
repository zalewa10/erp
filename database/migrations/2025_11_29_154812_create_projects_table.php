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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // nazwa zlecenia/projektu
            $table->unsignedBigInteger('client_id')->nullable(); // klient z tabeli clients
            $table->decimal('amount', 10, 2)->nullable();    // pełna kwota projektu
            $table->text('description')->nullable();         // opis projektu
            $table->string('status')->default('new');        // new, in_progress, done
            $table->timestamps();

            // relacja z clients
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->nullOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
