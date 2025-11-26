<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // podstawowe dane zadania
            $table->string('title');
            $table->text('description')->nullable();

            // relacja: zadanie dotyczy klienta
            $table->foreignId('client_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // relacja: zadanie przypisane do użytkownika (wykonawcy)
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // relacja: użytkownik, który utworzył zadanie
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // relacja: priorytet zadania
            $table->foreignId('priority_id')
                ->nullable()
                ->constrained('priorities')
                ->nullOnDelete();

            // dodatkowe informacje o zadaniu
            $table->dateTime('due_date')->nullable();       // termin wykonania
            $table->boolean('billed')->default(false);      // czy zadanie rozliczone?
            $table->decimal('amount', 10, 2)->nullable();   // koszt

            $table->timestamps(); // created_at, updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
