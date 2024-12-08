<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        // Apply Sanctum middleware and restrict certain actions to admins
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Fetch all products.
     */
    public function index()
    {
        try {
            $products = Product::all();

            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch a single product by ID.
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Add a new product (Admin only).
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'barcode' => 'required|unique:products',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'category' => 'required|string|max:100',
            ]);

            $product = Product::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product added successfully',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing product (Admin only).
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'price' => 'nullable|numeric|min:0',
                'quantity' => 'nullable|integer|min:0',
                'description' => 'nullable|string|max:255',
                'barcode' => 'nullable|string|unique:products,barcode,' . $id,
                'category' => 'nullable|string|max:100',
            ]);

            $product->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product (Admin only).
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
