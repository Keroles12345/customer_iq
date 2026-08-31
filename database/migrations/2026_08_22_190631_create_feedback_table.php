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
    Schema::create('feedback', function (Blueprint $table) {
    $table->id();

    $table->foreignId('customer_id')
        ->nullable()
        ->constrained('customers')
        ->nullOnDelete();

    $table->unsignedTinyInteger('rating');

    $table->text('message');

    $table->enum('sentiment', [
        'positive',
        'neutral',
        'negative'
    ])->nullable();

    $table->enum('status', [
        'new',
        'reviewed',
        'resolved'
    ])->default('new');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
