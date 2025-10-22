<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/produtos
    public function index(Request $request)
    {
        $q = Product::query();

        if ($s = $request->query('search')) {
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%$s%")
                   ->orWhere('sku', 'like', "%$s%");
            });
        }

        if ($request->boolean('featured')) {
            $q->where('is_featured', true);
        }

        if ($min = $request->query('min_price')) {
            $q->where('price', '>=', $min);
        }

        if ($max = $request->query('max_price')) {
            $q->where('price', '<=', $max);
        }

        $sort = $request->query('sort', '-id');
        $dir  = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $col  = ltrim($sort, '-');

        if (!in_array($col, ['id', 'name', 'price', 'stock', 'created_at'])) {
            $col = 'id';
        }

        $q->orderBy($col, $dir);
        $perPage = min((int) $request->query('per_page', 12), 100);

        return ProductResource::collection($q->paginate($perPage));
    }

    // GET /api/produtos/destaques
    public function featured()
    {
        $items = Product::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        return ProductResource::collection($items);
    }

    // GET /api/produtos/{id}
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    // POST /api/produtos
    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'image_url' => 'nullable|url',
        ]);

        $product = Product::create($data);
        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    // PUT/PATCH /api/produtos/{id}
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'sku' => 'sometimes|string|max:50|unique:products,sku,' . $product->id,
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'is_featured' => 'boolean',
            'image_url' => 'nullable|url',
        ]);

        $product->update($data);
        return new ProductResource($product);
    }

    // DELETE /api/produtos/{id}
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['ok' => true]);
    }
}
