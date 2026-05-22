<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $query = Customer::query();

        if ($status !== null) {
            if (!in_array($status, ['active', 'inactive'], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => [
                        'status' => ['The selected status is invalid.'],
                    ]
                ], 422);
            }
            $query->where('status', $status === 'active');
        }

        $customers = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Customers retrieved successfully',
            'data' => $customers,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'string', 'unique:customers,customer_id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = $data['status'] ?? true;
        $customer = Customer::query()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $customerData = Customer::query()->find($id);

        if (!$customerData) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer retrieved successfully',
            'data' => $customerData,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $customerData = Customer::query()->find($id);

        if (!$customerData) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
                'errors' => [],
            ], 404);
        }

        $data = $request->validate([
            'customer_id' => ['sometimes', 'string', 'unique:customers,customer_id,' . $id],
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', 'unique:customers,email,' . $id],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $customerData->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'data' => $customerData,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $customerData = Customer::query()->find($id);

        if (!$customerData) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
                'errors' => [],
            ], 404);
        }

        if ($customerData->subscriptions()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Customer cannot be deleted because it has subscriptions',
                'errors' => [],
            ], 422);
        }

        $customerData->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
            'data' => null,
        ]);
    }

    public function changeStatus(Request $request, int $id): JsonResponse
    {
        $customer = Customer::query()->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $request->validate(['status' => ['required', 'boolean']]);
        $customer->update(['status' => $request->boolean('status')]);

        return response()->json([
            'success' => true,
            'message' => 'Customer status changed successfully',
            'data' => $customer,
        ]);
    }
}