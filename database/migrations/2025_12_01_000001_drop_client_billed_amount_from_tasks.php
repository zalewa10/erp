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
        Schema::table('tasks', function (Blueprint $table) {
            // Drop foreign key then column if exists
            if (Schema::hasColumn('tasks', 'client_id')) {
                // try drop foreign constraint if it exists
                try {
                    $table->dropForeign(['client_id']);
                } catch (\Exception $e) {
                    // ignore if constraint doesn't exist
                }
                $table->dropColumn('client_id');
            }

            if (Schema::hasColumn('tasks', 'billed')) {
                $table->dropColumn('billed');
            }

            if (Schema::hasColumn('tasks', 'amount')) {
                $table->dropColumn('amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'client_id')) {
                $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete()->after('title');
            }

            if (! Schema::hasColumn('tasks', 'billed')) {
                $table->boolean('billed')->default(false)->after('due_date');
            }

            if (! Schema::hasColumn('tasks', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable()->after('billed');
            }
        });
    }
};
