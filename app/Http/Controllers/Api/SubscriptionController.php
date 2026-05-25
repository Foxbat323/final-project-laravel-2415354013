<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Subscription::with(['customer', 'service']);

        // Kalau ada parameter ?status=active/inactive/dsb
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        $subscriptions = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Subscriptions retrieved successfully',
            'data' => $subscriptions,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'string', 'in:active,inactive,trial,isolir,dismantle'],
        ]);

        $subscription = Subscription::query()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => $subscription,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $subscription = Subscription::with(['customer', 'service'])->find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription retrieved successfully',
            'data' => $subscription,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $subscription = Subscription::query()->find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
                'errors' => [],
            ], 404);
        }

        if ($subscription->status === 'dismantle') {
            return response()->json([
                'success' => false,
                'message' => 'Subscription cannot be updated because it is already dismantled',
                'errors' => [],
            ], 422); 
        }

        $data = $request->validate([
            'customer_id' => ['sometimes', 'exists:customers,id'],
            'service_id' => ['sometimes', 'exists:services,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['sometimes', 'string', 'in:active,inactive,trial,isolir,dismantle'],
        ]);

        $subscription->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Subscription updated successfully',
            'data' => $subscription,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $subscription = Subscription::query()->find($id);

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
                'errors' => [],
            ], 404);
        }

        $subscription->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully',
            'data' => null,
        ]);
    }

    public function changeStatus(Request $request, int $id): JsonResponse
    {
        $subscription = Subscription::query()->find($id);

        if (!$subscription) {
            return response()->json(['success' => false, 'message' => 'Subscription not found'], 404);
        }

        
        if ($subscription->status === 'dismantle') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot change status because it is already dismantled'
            ], 422); 
        }

        $request->validate([
            'status' => ['required', 'string', 'in:active,inactive,trial,isolir,dismantle']
        ]);

        $subscription->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription status changed successfully',
            'data' => $subscription,
        ]);
    }
}