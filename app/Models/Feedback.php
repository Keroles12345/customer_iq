<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeedbackCategory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $fillable = ['customer_id', 'rating', 'message', 'sentiment', 'status'];

    protected function casts(): array
    {
        return ['rating' => 'integer'];
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function categories()
    {
        return $this->belongsToMany(FeedbackCategory::class, 'feedback_feedback_category', 'feedback_id', 'feedback_category_id');
    }
}
