<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FeedbackCategory;
use Illuminate\Http\Request;

class FeedbackCategoryController extends Controller
{
    public function index()
    {
        return FeedbackCategory::withCount('feedback')->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $category = FeedbackCategory::create($request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:feedback_categories,name'],
            'description' => ['nullable', 'string'],
        ]));
        return response()->json($category, 201);
    }

    public function show(FeedbackCategory $feedbackCategory)
    {
        return $feedbackCategory->load('feedback');
    }

    public function update(Request $request, FeedbackCategory $feedbackCategory)
    {
        $feedbackCategory->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:feedback_categories,name,' . $feedbackCategory->id],
            'description' => ['sometimes', 'nullable', 'string'],
        ]));
        return $feedbackCategory->fresh();
    }

    public function destroy(FeedbackCategory $feedbackCategory)
    {
        $feedbackCategory->delete();
        return response()->noContent();
    }
}
