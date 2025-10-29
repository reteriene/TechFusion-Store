<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

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
        // validação básica
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120', // 5MB
        ]);

        // gera SKU único
        do {
            $sku = strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        $product = new Product();
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'] ?? null;
        $product->is_featured = !empty($data['is_featured']) && $data['is_featured'] ? 1 : 0;
        $product->sku = $sku;

        // trata upload se existir
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return response()->json([
            'product' => $product
        ], 201);
    }
}
