<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VNPayController extends Controller
{
    //
    public function form()
    {
        return view('client.premium.form');
    }

    public function createPayment(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/payment/vnpay/return"; // ❗ URL thật, KHÔNG dùng 127.0.0.1
        $vnp_TmnCode = "HSCLHHWX"; // Mã TMNCode được cấp bởi VNPay
        $vnp_HashSecret = "0NJMWF5136N13WH87X9943MO0MYTOKZD"; // Chuỗi bí mật

        $vnp_TxnRef = time(); // Mã đơn hàng (nên là duy nhất)
        $vnp_OrderInfo = "Thanh toan 1 thang Premium";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = 100000 * 100; // Số tiền x100
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // B1: Sắp xếp dữ liệu theo key A-Z
        ksort($inputData);

        // B2: Tạo chuỗi query + hash
        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // B3: Tạo secure hash
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . $query . "vnp_SecureHash=" . $vnp_SecureHash;

        return redirect($vnp_Url);
    }


    public function handleReturn(Request $request)
    {
        $vnp_HashSecret = "0NJMWF5136N13WH87X9943MO0MYTOKZD";
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHashCheck === $vnp_SecureHash && $inputData['vnp_ResponseCode'] == '00') {
            $user = auth()->user();
            Log::info('User debug', [
                'auth_user' => auth()->user(),
                'session' => session()->all(),
            ]);
            $user->update([
                'is_premium' => true,
                'premium_expires_at' => now()->addDays(30),
            ]);

            Order::create([
                'user_id' => $user->id,
                'amount' => $inputData['vnp_Amount'] / 100,
                'payment_method' => 'vnpay',
                'status' => 'paid',
            ]);
            return redirect()->route('client.home')->with('success', 'Bạn đã đăng ký Premium thành công!');
        } else {
            return redirect()->route('premium.form')->with('error', 'Thanh toán thất bại!');
        }
    }

    // public function handleReturn(Request $request)
    // {
    //     $inputData = $request->all();
    //     $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';

    //     unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);
    //     ksort($inputData);

    //     $hashData = '';
    //     foreach ($inputData as $key => $value) {
    //         $hashData .= $key . '=' . $value . '&';
    //     }
    //     $hashData = rtrim($hashData, '&');

    //     $secureHashCheck = hash_hmac('sha512', $hashData, env('VNPAY_HASH_SECRET'));

    //     if ($secureHashCheck === $vnp_SecureHash && $inputData['vnp_ResponseCode'] == '00') {
    //         $user = auth()->user();

    //         $user->update([
    //             'is_premium' => true,
    //             'premium_expires_at' => now()->addDays(30),
    //         ]);

    //         Order::create([
    //             'user_id' => $user->id,
    //             'amount' => $inputData['vnp_Amount'] / 100,
    //             'payment_method' => 'vnpay',
    //             'status' => 'paid',
    //         ]);

    //         return redirect()->route('home')->with('success', 'Bạn đã đăng ký Premium thành công!');
    //     }
    //     dd([
    //         'responseCode' => $inputData['vnp_ResponseCode'] ?? 'N/A',
    //         'vnp_SecureHash' => $vnp_SecureHash,
    //         'secureHashCheck' => $secureHashCheck,
    //         'hashData' => $hashData,
    //         'auth' => auth()->user(),
    //     ]);

    //     return redirect()->route('premium.form')->with('error', 'Thanh toán thất bại!');
    // }
}
