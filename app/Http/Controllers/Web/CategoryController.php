<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where('user_id', $request->user()->id)
                    ->where('type', $request->input('type')),
            ],
            'type' => ['required', 'string', 'in:income,expense'],
        ], [
            'name.unique' => 'You already have a category with this name and type.',
        ]);

        Category::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Category created successfully.');
    }
}
