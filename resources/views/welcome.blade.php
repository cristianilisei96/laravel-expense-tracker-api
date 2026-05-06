<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Expense Tracker API</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main>
            <section class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center rounded-full bg-gray-200 px-3 py-1 text-sm text-gray-700 mb-6">
                        Laravel Portfolio Project
                    </div>

                    <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900 leading-tight">
                        Expense tracker with REST API and visual dashboard
                    </h1>

                    <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                        A Laravel application for tracking income and expenses, built with a Sanctum-powered REST API,
                        user-owned categories, transactions, monthly summaries and a clean web dashboard.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex justify-center items-center px-5 py-3 bg-gray-900 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700">
                                Open dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="inline-flex justify-center items-center px-5 py-3 bg-gray-900 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700">
                                Create account
                            </a>

                            <a href="{{ route('login') }}"
                                class="inline-flex justify-center items-center px-5 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-100">
                                Login
                            </a>
                        @endauth

                        <a href="https://github.com/cristianilisei96/laravel-expense-tracker-api" target="_blank"
                            class="inline-flex justify-center items-center px-5 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-100">
                            GitHub repo
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                            <div class="text-3xl font-bold text-gray-900">
                                API
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                Token-based authentication and JSON endpoints using Laravel Sanctum.
                            </p>
                        </div>

                        <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                            <div class="text-3xl font-bold text-gray-900">
                                Web
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                Visual dashboard for managing categories and transactions.
                            </p>
                        </div>

                        <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                            <div class="text-3xl font-bold text-gray-900">
                                Reports
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                Monthly income, expenses and balance summaries per user.
                            </p>
                        </div>

                        <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                            <div class="text-3xl font-bold text-gray-900">
                                Auth
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                User-specific data ownership for categories and transactions.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white border-y border-gray-200">
                <div class="max-w-7xl mx-auto px-6 py-14">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">
                        Main features
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-6 rounded-xl border border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-2">
                                REST API
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Register, login, logout, categories, transactions and monthly summary endpoints.
                            </p>
                        </div>

                        <div class="p-6 rounded-xl border border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-2">
                                Dashboard
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Add categories, add transactions, view totals and manage recent records.
                            </p>
                        </div>

                        <div class="p-6 rounded-xl border border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-2">
                                User data ownership
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Each user can only access their own categories, transactions and financial reports.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="max-w-7xl mx-auto px-6 py-14">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">
                    API endpoints
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Authentication</h3>

                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-green-700">POST</span> <code>/api/register</code></div>
                            <div><span class="font-semibold text-green-700">POST</span> <code>/api/login</code></div>
                            <div><span class="font-semibold text-blue-700">GET</span> <code>/api/user</code></div>
                            <div><span class="font-semibold text-green-700">POST</span> <code>/api/logout</code></div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Expense tracker</h3>

                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-blue-700">GET</span> <code>/api/categories</code></div>
                            <div><span class="font-semibold text-green-700">POST</span> <code>/api/categories</code>
                            </div>
                            <div><span class="font-semibold text-blue-700">GET</span> <code>/api/transactions</code>
                            </div>
                            <div><span class="font-semibold text-green-700">POST</span> <code>/api/transactions</code>
                            </div>
                            <div><span class="font-semibold text-blue-700">GET</span>
                                <code>/api/reports/monthly-summary?month=2026-05</code>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white border-y border-gray-200">
                <div class="max-w-7xl mx-auto px-6 py-14">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">
                        Tech stack
                    </h2>

                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Laravel</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">PHP</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">MySQL</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Blade</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Tailwind
                            CSS</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Laravel
                            Breeze</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Laravel
                            Sanctum</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">REST API</span>
                        <span class="px-4 py-2 rounded-full bg-gray-50 border border-gray-200 text-sm">Postman</span>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-200 bg-white">
            <div
                class="max-w-7xl mx-auto px-6 py-6 text-sm text-gray-500 flex flex-col sm:flex-row justify-between gap-2">
                <span>
                    Laravel Expense Tracker API
                </span>

                <span>
                    Portfolio project by Cristian Ilisei
                </span>
            </div>
        </footer>
    </div>
</body>

</html>
