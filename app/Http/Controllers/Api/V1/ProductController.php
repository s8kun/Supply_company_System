<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection(Product::latest()->paginate(10))
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->uploadImage($request, 'image', 'products');

        $product = Product::create($data);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $data['image'] = $this->uploadImage($request, 'image', 'products');
        }

        $product->update($data);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->deleteImage($product->image);

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }

    /**
     * Upload an image.
     */
    private function uploadImage(Request $request, string $key, string $folder): ?string
    {
        if ($request->hasFile($key)) {
            return $request->file($key)->store($folder, 'public');
        }
        return null;
    }

    /**
     * Delete an image.
     */
    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
