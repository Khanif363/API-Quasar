<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Successfully get all categories!',
            'categories' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                'message' => 'Successfully get category!',
                'category' => $category
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found!'
            ], 404);
        }
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Successfully create category!',
            'category' => $category
        ], 201);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update([
                'name' => $request->name,
            ]);
            return response()->json([
                'message' => 'Successfully update category!',
                'category' => $category
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found!'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                'message' => 'Successfully delete category!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found!'
            ], 404);
        }
    }
}
