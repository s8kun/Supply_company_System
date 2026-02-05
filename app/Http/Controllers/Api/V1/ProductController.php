<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Inject image service for product uploads.
     */
    public function __construct(protected ImageService $imageService)
    {
    }

    /**
     * List products with pagination.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection(Product::latest()->paginate(10))
        ], 200);
    }

    /**
     * Create a product and upload optional image array.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $this->imageService->upload($image, 'products');
            }
            $data['images'] = $paths;
        } else {
            unset($data['images']);
        }

        $product = Product::create($data);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Show a single product.
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Update product details and replace images if provided.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            foreach (($product->images ?? []) as $path) {
                $this->imageService->delete($path);
            }

            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $this->imageService->upload($image, 'products');
            }
            $data['images'] = $paths;
        } else {
            unset($data['images']);
        }

        $product->update($data);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product->fresh())
        ], 200);
    }

    /**
     * Delete a product and its stored images.
     */
    public function destroy(Product $product)
    {
        foreach (($product->images ?? []) as $path) {
            $this->imageService->delete($path);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
