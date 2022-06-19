<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;

class SubcategoryController extends Controller
{
    public function store(StoreSubcategoryRequest $request)
    {
        $validated = $request->validated();
        return Subcategory::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['categoryId'],
        ]);
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory)
    {
        $validated = $request->validated();
        $subcategory->fill($validated);
        $subcategory->save();
        return $subcategory;
    }

    public function index(Request $request)
    {
        if ($request->has('limit')) {
            $total = Subcategory::count();
            $skipped = ($request['page'] - 1) * $request['limit'];
            $data = Subcategory::OrderBy('id', 'desc')
                ->skip($skipped)
                ->take($request['limit'])
                ->get();
            return compact('data', 'total');
        }

        return ['data' => Subcategory::OrderBy('id', 'desc')->get()];
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
    }

    public function show(Request $request, $id)
    {
        $subcategory = Subcategory::where('slug', '=', $id)->first();
        $total = Product::where('subcategory_slug', '=', $id)->count();
        $limit = (int) $request['limit'];
        $skipped = ((int) $request['page'] - 1) * $limit;
        $data = Product::where('subcategory_slug', '=', $id)
            ->with('authors', 'cover')
            ->latest()
            ->skip($skipped)
            ->take($limit)
            ->get();

        return compact('data', 'total');
    }
}
