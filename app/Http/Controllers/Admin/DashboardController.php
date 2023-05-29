<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $numberOfUsers = count(User::all());
        $numberOfOrders = count(Order::all());
        $estimatedRevenue = DB::table('orders')->sum('subtotal');
        $fixedRevenue = DB::table('orders')->where('checkout_status', 1)->sum('subtotal');
        $active = "dashboard";
        return view('backend.dashboard', compact('active', 'numberOfUsers', 'numberOfOrders', 'estimatedRevenue', 'fixedRevenue'));
    }
}
