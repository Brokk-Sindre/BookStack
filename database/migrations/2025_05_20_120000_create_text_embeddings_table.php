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
        Schema::create('text_embeddings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity_type', 100);
            $table->unsignedBigInteger('entity_id');
            $table->longText('embedding');
            $table->unique(['entity_type', 'entity_id'], 'text_embeddings_entity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_embeddings');
    }
};
