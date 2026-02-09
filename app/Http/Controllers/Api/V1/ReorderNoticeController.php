<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReorderNoticeResource;
use App\Models\ReorderNotice;
use Illuminate\Http\JsonResponse;

class ReorderNoticeController extends Controller
{
    /**
     * List reorder notices with pagination.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => ReorderNoticeResource::collection(
                ReorderNotice::query()->latest()->paginate(10)
            ),
        ], 200);
    }

    /**
     * Show a single reorder notice.
     */
    public function show(ReorderNotice $reorderNotice): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new ReorderNoticeResource($reorderNotice),
        ], 200);
    }
}
