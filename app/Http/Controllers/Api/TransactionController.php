<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $transactions = Transaction::query()
            ->with('category')
            ->where('user_id', $request->user()->id)
            ->when($request->query('type'), function ($query, string $type) {
                $query->where('type', $type);
            })
            ->when($request->query('category_id'), function ($query, string $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->query('date_from'), function ($query, string $dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($request->query('date_to'), function ($query, string $dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->latest('transaction_date')
            ->paginate(10);

        return response()->json($transactions);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'type' => ['required', 'string', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ]);

        if (!empty($validated['category_id'])) {
            $this->ensureCategoryBelongsToUser(
                (int) $validated['category_id'],
                $request->user()->id,
                $validated['type']
            );
        }

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'] ?? null,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'transaction_date' => $validated['transaction_date'],
        ]);

        $transaction->load('category');

        return response()->json([
            'message' => 'Transaction created successfully.',
            'data' => $transaction,
        ], 201);
    }

    public function show(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $transaction->load('category');

        return response()->json([
            'data' => $transaction,
        ]);
    }

    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'type' => ['required', 'string', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ]);

        if (!empty($validated['category_id'])) {
            $this->ensureCategoryBelongsToUser(
                (int) $validated['category_id'],
                $request->user()->id,
                $validated['type']
            );
        }

        $transaction->update($validated);
        $transaction->load('category');

        return response()->json([
            'message' => 'Transaction updated successfully.',
            'data' => $transaction,
        ]);
    }

    public function destroy(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully.',
        ]);
    }

    private function ensureCategoryBelongsToUser(int $categoryId, int $userId, string $type): void
    {
        $category = Category::query()
            ->where('id', $categoryId)
            ->where('user_id', $userId)
            ->where('type', $type)
            ->first();

        if (!$category) {
            abort(422, 'The selected category is invalid for this user or transaction type.');
        }
    }
}
