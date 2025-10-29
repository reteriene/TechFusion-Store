<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Retorna todos os produtos
    public function index()
    {
        return response()->json(Product::all());
    }

    // Cria um novo produto
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image',
                'is_featured' => 'boolean',
            ]);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($data);

            return response()->json([
                'success' => true,
                'product' => $product,
            ], 201);
        } catch (\Throwable $e) {
            \Log::error('Erro ao salvar produto: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
