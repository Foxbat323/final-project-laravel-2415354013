<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Services retrieved successfully',
            'data' => $services,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = $data['status'] ?? true;
        $service = Service::query()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully',
            'data' => $service,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $service = Service::query()->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Service retrieved successfully',
            'data' => $service,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $service = Service::query()->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
                'errors' => [],
            ], 404);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'price' => ['sometimes', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $service->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully',
            'data' => $service,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $service = Service::query()->find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
                'errors' => [],
            ], 404);
        }

        if ($service->subscriptions()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Service cannot be deleted because it has active subscriptions',
                'errors' => [],
            ], 422);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully',
            'data' => null,
        ]);
    }
}