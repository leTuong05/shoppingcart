<?php

namespace App\Http\Controllers\Shopping;

use App\Events\MessageNotification;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function cod() 
    {
        if (request()->ajax()) {
            $params = request()->all();
            
            $array = array();
            foreach (session('cart') as $key => $value) {
                array_push($array, $value['id'].'-'.$value['quantity']);
            }
            $type = implode(',',$array);

            $paramID = auth()->id();
            $string = date("YmdHis");
            $order_id = $string."-".$paramID;
            DB::beginTransaction();

            try {
                
                if (data_get($params, 'ward') != '-1') {
                    
                    $order = Order::create([
                        'payment_type' => "COD",
                        'checkout_status' => 0,
                        'user_id' => auth()->user()->id,
                        'details_address' => $params['detailsAddress'],
                        'created_at' => now(),
                        'is_read' => false,
                        'city' => DB::table('devvn_tinhthanhpho')->select('name')->where('matp', $params['province'])->first()->name,
                        'district' => DB::table('devvn_quanhuyen')->select('name')->where('maqh', $params['district'])->first()->name,
                        'ward' => DB::table('devvn_xaphuongthitran')->select('name')->where('xaid', $params['ward'])->first()->name,
                        'order_id'=> $order_id,
                        'subtotal' => $params['total_price'],
                        'name' => $params['name'],
                        'note_shipping' => $params['note'],
                        'phone_number' => $params['phone_number'],
                        'type' => $type,
                    ]);

                    if($order) {
                        foreach (session('cart') as $key => $value) {
                            OrderDetail::create([
                                'products_id' => $key,
                                'name' => Product::where('id', $value['id'])->first()->name,
                                'user_id' => auth()->user()->id,
                                'quantity' => $value['quantity'],
                                'order_id' => $order->order_id,
                                'total' => $value['quantity']*$value['price'],
                                'created_at'=> now()
                            ]);
                        }
                        DB::commit();
                        event(new MessageNotification($order, 'Đơn hàng từ khách hàng: '.Auth::guard('web')->user()->name));
                        session()->forget(['cart']);
                        return [
                            'status' => true,
                        ];
                    }
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);

                return [
                    'status' => false,
                ];
            }
        }
    }

    public function create() 
    {
        if (request()->ajax()) {
            $params = request()->all();
            
            $paramID = auth()->id();
            $string = date("YmdHis");
            $order_id = $string."-".$paramID;

            $array = array();
            foreach (session('cart') as $key => $value) {
                array_push($array, $value['id'].'-'.$value['quantity']);
            }
            $type = implode(',',$array);

            DB::beginTransaction();
            try {
                if (data_get($params, 'ward') != '-1') {
                    $order = Order::create([
                        'payment_type' => "Online",
                        'checkout_status' => 0,
                        'user_id' => auth()->user()->id,
                        'details_address' => $params['detailsAddress'],
                        'created_at' => now(),
                        'is_read' => false,
                        'city' => DB::table('devvn_tinhthanhpho')->select('name')->where('matp', $params['province'])->first()->name,
                        'district' => DB::table('devvn_quanhuyen')->select('name')->where('maqh', $params['district'])->first()->name,
                        'ward' => DB::table('devvn_xaphuongthitran')->select('name')->where('xaid', $params['ward'])->first()->name,
                        'order_id'=> $order_id,
                        'subtotal' => $params['total_price'],
                        'name' => $params['name'],
                        'note_shipping' => $params['note'],
                        'phone_number' => $params['phone_number'],
                        'type' => $type,
                    ]);
                    
                    if ($order) {
                        event(new MessageNotification($order, 'Đơn hàng từ khách hàng: '.Auth::guard('web')->user()->name));
                        foreach (session('cart') as $key => $value) {
                            OrderDetail::create([
                                'products_id' => $key,
                                'name' => Product::where('id', $value['id'])->first()->name,
                                'user_id' => auth()->user()->id,
                                'quantity' => $value['quantity'],
                                'order_id' => $order->order_id,
                                'total' => $value['quantity']*$value['price'],
                                'created_at'=>now()
                            ]);
                        }
                        DB::commit();
                    }

                    $vnp_TmnCode = "JSEREFVO"; //Mã website tại VNPAY 
                    $vnp_HashSecret = "WNKJOVWEXKQGVEDBJLEUSJAKICTYRPVV"; //Chuỗi bí mật
                    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                    $vnp_Returnurl = "https://localhost/payments/online/vnpayreturn";
                    $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
                    $vnp_TxnRef = $order->id;
                    $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ. Số tiền ".number_format(request()->total_price).' đ';
                    $vnp_OrderType = 'billpayment';
                    $vnp_Amount = request()->total_price * 100;
                    $vnp_Locale = 'vn';
                    $vnp_IpAddr = request()->ip();

                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $startTime = date("YmdHis");
                    $vnp_ExpireDate = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

                    $inputData = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount,
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_OrderInfo,
                        "vnp_OrderType" => $vnp_OrderType,
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                        "vnp_ExpireDate"=>$vnp_ExpireDate,
                    );

                    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                        $inputData['vnp_BankCode'] = $vnp_BankCode;
                    }
                    
                    ksort($inputData);
                    $query = "";
                    $i = 0;
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashdata .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }
        
                    $vnp_Url = $vnp_Url . "?" . $query;
                    if (isset($vnp_HashSecret)) {
                        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                    }
                    
                    return response()->json(['link'=>$vnp_Url]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
                return [
                    'status' => false,
                ];
            }

        }
    }

    public function return()
    {
        $vnp_HashSecret = "WNKJOVWEXKQGVEDBJLEUSJAKICTYRPVV"; //Chuỗi bí mật
        
        $inputData = array();

        foreach (request()->input() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra total của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   
                $order = Order::where('id', $orderId)->first();

                if ($order) {
                    $total = 0;
                    $all_order = explode(',', $order->type);
                    
                    foreach ($all_order as $one) {
                        $all = explode('-', $one);
                        $product_id = $all[0];
                        $product_info = Product::where('id', $product_id)->first();
                        $product_quantity = intval($all[1]);
                        $total += (intval($all[1])*$product_info->price)*110/100;
                    }
                    
                    if ($total == $vnp_Amount) {

                        if ($order->checkout_status == 0) {

                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                session()->flash('success', 'Xác nhận thanh toán thành công');
                                $status = 1; // Trạng thái thanh toán thành công
                                session()->forget(['cart']);
                                
                            } else {
                                session()->flash('error', 'Xác nhận thanh toán thất bại');
                                $status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            // Cập nhật trạng thái đơn hàng
                            Order::where('id',$orderId)->update([
                                'checkout_status' => $status,
                            ]);

                            return redirect('/');

                        } else {
                            session()->flash('error', 'Đơn hàng đã được xác nhận');
                        }

                    } else {
                        session()->flash('error', 'Lỗi giá trị đơn hàng');
                    }

                } else {
                    session()->flash('error', 'Đơn hàng không tồn tại');
                }

            } else {
                session()->flash('error', 'Lỗi chữ ký');
            }

        } catch (Exception $e) {
            session()->flash('error', 'Lỗi không xác định');
        }

        return redirect('/checkout');
    }
}
