<?php

namespace App\Http\Controllers\Subscription;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class SubscriptionController extends Controller
{
    public function index()
    {
        // عرض جميع الباقات
        $plans = Plan::with('groups')->get();
        return responseApi(200,'successfully',$plans);
    }

    public function subscribe(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
        ]);

        // إنشاء اشتراك جديد
        $subscription = Subscription::create([
            'user_id' => $validated['user_id'],
            'plan_id' => $validated['plan_id'],
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'payment_status' => 'pending',
        ]);

        return responseApi(200,'Subscription created successfully',$subscription);
    }
    public function processPayment($id)
    {
        $subscription = Subscription::findOrFail($id);
        $plan = $subscription->plan;

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [   
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $plan->price,
                    ],
                ],
            ],
        ]);

        return response()->json($response);
    }

    public function trialLesson($planId)
    {
        $plan = Plan::with('trialLesson')->findOrFail($planId);

        if (!$plan->has_trial_lesson) {
            return response()->json(['message' => 'No trial lesson available for this plan'], 404);
        }

        return response()->json([
            'plan' => $plan->name,
            'trial_lesson' => $plan->trialLesson,
        ]);
    }
}
