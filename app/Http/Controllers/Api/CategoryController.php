<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::query()
            ->where('user_id', $request->user()->id)
            ->when($request->query('type'), function ($query, string $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:income,expense'],
        ]);

        $category = Category::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
        ]);

        return response()->json([
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201);
    }

    public function show(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json([
            'data' => $category,
        ]);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:income,expense'],
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category,
        ]);
    }

    public function destroy(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            abort(403);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
