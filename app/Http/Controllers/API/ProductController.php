<?php

// app/Http/Controllers/API/ProductController.php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        return Product::with('images')->get();
    }

    public function show($id) {
        return Product::with('images')->findOrFail($id);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'string|max:255',
            'price' => 'required|numeric',
            'stock' => 'integer',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048', // multiple images
        ]);
    
        $product = Product::create($request->only([
            'name', 'category', 'price', 'stock', 'description'
        ]));
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
    
        return response()->json($product->load('images'), 201);
    }
    
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'images.*' => 'nullable|image|max:9000', // multiple images
        ]);
    
        $product->update($request->only(['name', 'description', 'price']));
    
        if ($request->hasFile('images')) {
            // optional: delete old images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
    
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
    
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->load('images')
        ]);
    }
    

    public function destroy($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}

