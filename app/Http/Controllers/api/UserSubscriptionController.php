<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPackageSubscription;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserSubscriptionController extends Controller
{
    // ✅ First Time
    public function subscribe(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $user = Auth::user();
        $package = Package::findOrFail($request->package_id);

        // إنهاء أي اشتراك حالي
        UserPackageSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update([
                'status' => 'expired',
                'ends_at' => now(),
            ]);

        $start = now();
        if($package->period_type == 'Years'){
            $period = $package->period * 12;
            $end = $start->copy()->addMonths($period);
        }else{
            $end = $start->copy()->addMonths($package->period);
        }

        $subscription = UserPackageSubscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'price' => $package->price,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'active',
            'renewed' => false,
        ]);

        return response()->json(['message' => 'Subscribed successfully', 'subscription' => $subscription]);
    }

    // ✅ التجديد
    public function renew()
    {
        $user = Auth::user();
        $current = $user->subscriptions()->where('status', 'active')->latest('starts_at')->first();

        if (!$current) {
            return response()->json(['message' => 'No active subscription to renew'], 400);
        }

        $start = $current->ends_at;

        if($current->package->period_type == 'Years'){
            $period = $current->package->period * 12;
            $end = $start->copy()->addMonths($period);
        }else{
            $end = $start->copy()->addMonths($current->package->period);
        }
        

        // إنهاء الاشتراك الحالي
        $current->update(['status' => 'expired', 'renewed' => true]);

        $new = UserPackageSubscription::create([
            'user_id' => $user->id,
            'package_id' => $current->package_id,
            'price' => $current->price,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'active',
            'renewed' => true,
        ]);

        return response()->json(['message' => 'Renewed successfully', 'subscription' => $new]);
    }

    // ✅ الترقية قبل نهاية الباقة
    public function upgrade(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $user = Auth::user();
        $newPackage = Package::findOrFail($request->package_id);
        $current = $user->subscriptions()->where('status', 'active')->latest('starts_at')->first();

        if (!$current) {
            return $this->subscribe($request); // لو مفيش باقة حالية، كأنها اشتراك جديد
        }

        $current->update(['status' => 'upgraded', 'ends_at' => now()]);

        $start = now();
        
        if($newPackage->period_type == 'Years'){
            $period = $newPackage->period * 12;
            $end = $start->copy()->addMonths($period);
        }else{
            $end = $start->copy()->addMonths($newPackage->period);
        }
        

        $new = UserPackageSubscription::create([
            'user_id' => $user->id,
            'package_id' => $newPackage->id,
            'price' => $newPackage->price,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'active',
        ]);

        return response()->json(['message' => 'Upgraded successfully', 'subscription' => $new]);
    }

    // ✅ الإلغاء
    public function cancel()
    {
        $user = Auth::user();
        $current = $user->subscriptions()->where('status', 'active')->latest('starts_at')->first();

        if (!$current) {
            return response()->json(['message' => 'No active subscription to cancel'], 400);
        }

        $current->update([
            'status' => 'cancelled',
            'ends_at' => now()
        ]);

        return response()->json(['message' => 'Subscription cancelled']);
    }

    // ✅ عرض الاشتراكات السابقة والحالية
    public function history()
    {
        $user = Auth::user();
        $all = $user->subscriptions()->with('package')->latest('starts_at')->get();

        return response()->json(['subscriptions' => $all]);
    }
}
