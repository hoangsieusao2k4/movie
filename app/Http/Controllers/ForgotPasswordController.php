<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //
    public function showFormEmail()
    {
        return view('client.auth.email');
    }

    // Gửi mã OTP
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        DB::table('password_resets_otp')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => Carbon::now()]
        );

        // Gửi mail
        Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Mã OTP đặt lại mật khẩu');
        });

        return redirect()->route('password.otp.form')->with('email', $request->email);
    }

    // Hiển thị form nhập OTP + mật khẩu mới
    public function showOtpForm(Request $request)
    {
        $email = session('email'); // Hoặc từ query nếu cần
        // dd($email);
        return view('client.auth.otp', compact('email'));
    }
    public function checkOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',

        ]);

        $record = DB::table('password_resets_otp')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác'])->withInput();
        }

        // Kiểm tra thời gian OTP còn hiệu lực (VD: 10 phút)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn'])->withInput();
        }

        // Cập nhật mật khẩu
        // User::where('email', $request->email)->update([
        //     'password' => Hash::make($request->password),
        // ]);

        // // Xóa OTP sau khi sử dụng
        // DB::table('password_resets_otp')->where('email', $request->email)->delete();
        session([
            'reset_email' => $request->email,
            'reset_otp' => $request->otp,
        ]);
        return redirect()->route('showReset');
    }
    public function showReset()
    {

        return view('client.auth.reset');
    }
    // Đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $email = session('reset_email');
        $otp = session('reset_otp');
//  dd($email,$otp);

        $request->validate([

            'password' => 'required|',
            'confirm-password' => 'required',
        ]);



        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets_otp')
            ->where('email', $email)
            ->where('otp', $otp)
            ->delete();

        // Xóa session
        session()->forget(['reset_email', 'reset_otp']);

        return redirect()->route('showLogin')->with('success', 'Đổi mật khẩu thành công!');
    }
}
