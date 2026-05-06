<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expense Tracker Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="warning" :message="session('warning')" />
            <x-flash-message type="danger" :message="session('error')" />

            @if ($errors->any())
                <x-flash-message type="danger" message="Please check the form errors below." />
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Income this month</div>
                    <div class="mt-2 text-3xl font-bold text-green-700">
                        ${{ number_format((float) $income, 2) }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Expenses this month</div>
                    <div class="mt-2 text-3xl font-bold text-red-700">
                        ${{ number_format((float) $expenses, 2) }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Balance this month</div>
                    <div class="mt-2 text-3xl font-bold {{ $balance >= 0 ? 'text-gray-900' : 'text-red-700' }}">
                        @if ($balance < 0)
                            -${{ number_format(abs((float) $balance), 2) }}
                        @else
                            ${{ number_format((float) $balance, 2) }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Add category
                    </h3>

                    <form method="POST" action="{{ route('web.categories.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="category_name" class="block text-sm font-medium text-gray-700">
                                Name
                            </label>
                            <input id="category_name" name="name" type="text" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Food, Salary, Transport..." required>

                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_type" class="block text-sm font-medium text-gray-700">
                                Type
                            </label>
                            <select id="category_type" name="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="expense" @selected(old('type') === 'expense')>Expense</option>
                                <option value="income" @selected(old('type') === 'income')>Income</option>
                            </select>

                            @error('type')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Add category
                        </button>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Add transaction
                    </h3>

                    <form method="POST" action="{{ route('web.transactions.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="transaction_type" class="block text-sm font-medium text-gray-700">
                                Type
                            </label>
                            <select id="transaction_type" name="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="expense" @selected(old('type') === 'expense')>Expense</option>
                                <option value="income" @selected(old('type') === 'income')>Income</option>
                            </select>

                            @error('type')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Category
                            </label>
                            <select id="category_id" name="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">No category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((int) old('category_id') === $category->id)>
                                        {{ $category->name }} — {{ ucfirst($category->type) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">
                                Amount
                            </label>
                            <input id="amount" name="amount" type="number" step="0.01" min="0.01"
                                value="{{ old('amount') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                            @error('amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700">
                                Date
                            </label>
                            <input id="transaction_date" name="transaction_date" type="date"
                                value="{{ old('transaction_date', now()->toDateString()) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

                            @error('transaction_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <input id="description" name="description" type="text" value="{{ old('description') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Lunch, salary, fuel...">

                            @error('description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Add transaction
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Latest transactions
                </h3>

                @if ($transactions->isEmpty())
                    <p class="text-gray-600">
                        No transactions yet. Add your first income or expense.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Type</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Category</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Description</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Amount</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
                                        </td>

                                        <td class="px-4 py-2">
                                            <span
                                                class="inline-flex items-center rounded px-2 py-1 text-xs font-medium
                                                {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $transaction->category?->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2 text-gray-600">
                                            {{ $transaction->description ?? '-' }}
                                        </td>

                                        <td
                                            class="px-4 py-2 text-right font-semibold {{ $transaction->type === 'income' ? 'text-green-700' : 'text-red-700' }}">
                                            @if ($transaction->type === 'income')
                                                +${{ number_format((float) $transaction->amount, 2) }}
                                            @else
                                                -${{ number_format((float) $transaction->amount, 2) }}
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <form method="POST"
                                                action="{{ route('web.transactions.destroy', $transaction) }}"
                                                onsubmit="return confirm('Delete this transaction?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-sm text-red-600 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
