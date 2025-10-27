<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function pay(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $order = Order::find($request->order_id);

        // Check order status
        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Order is already paid or cancelled.',
            ], 400);
        }

        DB::beginTransaction();

        try {
            //  Update order
            $order->status = 'paid';
            $order->save();

            //  Update user points
            $user = User::find($order->user_id);
            $pointsToAdd = $order->total_price;

            if ($order->total_price >= 100) {
                $pointsToAdd += 10; // bonus points
            }

            $user->points += $pointsToAdd;
            $user->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order paid successfully.',
                'order' => $order,
                'user_points' => $user->points,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
