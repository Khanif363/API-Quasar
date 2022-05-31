<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index (Request $request) {
        $products = Product::with('category')->where('name', 'like', '%' . $request->keyword . '%')->get();
        // Price * Quantity
        $products->transform(function ($product) {
            $product->price_total = $product->price * $product->quantity;
            return $product;
        });
        $totalprice = $products->sum('price_total');
        return response()->json([
            'message' => 'Successfully get all products!',
            'products' => $products,
            'totalprice' => $totalprice
        ], 200);

    }

    public function search (Request $request) {
        $product = Product::with('category')->where('name', 'like', '%' . $request->keyword . '%')->get();
        return response()->json([
            'message' => 'Successfully get all products!',
            'product' => $product,
        ], 200);
    }

    public function show ($id) {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'message' => 'Successfully get product!',
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
    }

    public function store (ProductRequest $request) {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);
        return response()->json([
            'message' => 'Successfully create product!',
            'product' => $product
        ], 201);
    }

    public function update (ProductRequest $request, $id) {
        $product = Product::find($id);
        if ($product) {
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);
            return response()->json([
                'message' => 'Successfully update product!',
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
    }

    public function destroy ($id) {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json([
                'message' => 'Successfully delete product!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
    }

}
