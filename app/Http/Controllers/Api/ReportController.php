<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function monthlySummary(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        $month = Carbon::createFromFormat('Y-m', $validated['month']);
        $startDate = $month->copy()->startOfMonth()->toDateString();
        $endDate = $month->copy()->endOfMonth()->toDateString();

        $income = Transaction::query()
            ->where('user_id', $request->user()->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::query()
            ->where('user_id', $request->user()->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $balance = (float) $income - (float) $expenses;

        return response()->json([
            'month' => $validated['month'],
            'income' => number_format((float) $income, 2, '.', ''),
            'expenses' => number_format((float) $expenses, 2, '.', ''),
            'balance' => number_format($balance, 2, '.', ''),
        ]);
    }
}
