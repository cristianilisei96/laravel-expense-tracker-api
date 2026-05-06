<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'type' => ['required', 'string', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ]);

        if (!empty($validated['category_id'])) {
            $category = Category::query()
                ->where('id', $validated['category_id'])
                ->where('user_id', $request->user()->id)
                ->where('type', $validated['type'])
                ->first();

            if (!$category) {
                return back()
                    ->withErrors([
                        'category_id' => 'The selected category is invalid for this transaction type.',
                    ])
                    ->withInput();
            }
        }

        Transaction::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'] ?? null,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'transaction_date' => $validated['transaction_date'],
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Transaction created successfully.');
    }
}
