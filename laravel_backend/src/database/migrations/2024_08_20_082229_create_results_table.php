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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keyword_id')->constrained(
                table: 'keywords', indexName: 'result_keyword_id'
            );
            $table->unsignedTinyInteger('google_rank')->default(0);
            $table->unsignedTinyInteger('yahoo_rank')->default(0);
            $table->unsignedInteger('google_total_hits')->default(0);
            $table->unsignedInteger('yahoo_total_hits')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign(['keyword_id']);
        });
        Schema::dropIfExists('results');
    }
};
