<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return Feedback::with(['customer', 'categories'])->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->storeRules());
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);
        $feedback = Feedback::create($data);
        $feedback->categories()->sync($categoryIds);
        return response()->json($feedback->load(['customer', 'categories']), 201);
    }

    public function show(Feedback $feedback)
    {
        return $feedback->load(['customer', 'categories']);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $data = $request->validate($this->updateRules());
        $categoryIds = $data['category_ids'] ?? null;
        unset($data['category_ids']);
        $feedback->update($data);
        if ($categoryIds !== null) {
            $feedback->categories()->sync($categoryIds);
        }
        return $feedback->fresh()->load(['customer', 'categories']);
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return response()->noContent();
    }

    private function storeRules(): array
    {
        return [
            'customer_id' => ['nullable', 'exists:customers,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'message' => ['required', 'string'],
            'sentiment' => ['nullable', 'in:positive,neutral,negative'],
            'status' => ['nullable', 'in:new,reviewed,resolved'],
            'category_ids' => ['sometimes', 'array'],
            'category_ids.*' => ['integer', 'exists:feedback_categories,id'],
        ];
    }

    private function updateRules(): array
    {
        return [
            'customer_id' => ['sometimes', 'nullable', 'exists:customers,id'],
            'rating' => ['sometimes', 'required', 'integer', 'between:1,5'],
            'message' => ['sometimes', 'required', 'string'],
            'sentiment' => ['sometimes', 'nullable', 'in:positive,neutral,negative'],
            'status' => ['sometimes', 'in:new,reviewed,resolved'],
            'category_ids' => ['sometimes', 'array'],
            'category_ids.*' => ['integer', 'exists:feedback_categories,id'],
        ];
    }
}
