<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        $income = Transaction::query()
            ->where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::query()
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $categories = Category::query()
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        $transactions = Transaction::query()
            ->with('category')
            ->where('user_id', $user->id)
            ->latest('transaction_date')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', [
            'income' => $income,
            'expenses' => $expenses,
            'balance' => (float) $income - (float) $expenses,
            'categories' => $categories,
            'transactions' => $transactions,
        ]);
    }
}
