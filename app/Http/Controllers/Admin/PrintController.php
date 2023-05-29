<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print($id)
    {
        $active = "orders";
        $order = Order::where('id', $id )->first();
        
        
        $orderDetails = OrderDetail::where('order_id', $order->order_id)->get();
        
        return view('backend.orders.print', compact('order', 'orderDetails', 'active'));
    }
}
