<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class FeedbackCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function feedback()
    {
        return $this->belongsToMany(Feedback::class, 'feedback_feedback_category', 'feedback_category_id', 'feedback_id');
    }
}
