<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('feedback_feedback_category');
        Schema::table('feedback_feedback_category', function (Blueprint $table) use ($columns) {
            if (!in_array('feedback_id', $columns, true)) {
                $table->foreignId('feedback_id')->constrained('feedback')->cascadeOnDelete();
            }
            if (!in_array('feedback_category_id', $columns, true)) {
                $table->foreignId('feedback_category_id')->constrained('feedback_categories')->cascadeOnDelete();
            }
        });

        $indexes = Schema::getIndexes('feedback_feedback_category');
        $hasLinkIndex = collect($indexes)->contains('name', 'feedback_category_link_unique');
        if (!$hasLinkIndex) {
            Schema::table('feedback_feedback_category', function (Blueprint $table) {
                $table->unique(['feedback_id', 'feedback_category_id'], 'feedback_category_link_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('feedback_feedback_category', function (Blueprint $table) {
            $table->dropForeign('feedback_feedback_category_feedback_id_foreign');
            $table->dropForeign('feedback_feedback_category_feedback_category_id_foreign');
            $table->dropUnique('feedback_category_link_unique');
            $table->dropColumn(['feedback_id', 'feedback_category_id']);
        });
    }
};
