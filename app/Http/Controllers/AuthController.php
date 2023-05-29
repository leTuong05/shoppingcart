<?php

namespace App\Http\Controllers;

use App\Mail\ContactMe;
use App\Mail\SendMail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try{
            $confirmation_code = time().uniqid(true);
            
            $data = $request->all();
            
            $users = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'confirmation_code' => $confirmation_code,
                'confirmed' => 0
            ]);
            
            $data['confirmation_code'] = $users->confirmation_code;
            
            Mail::send('emails.verify', $data, function($message) use ($data){
                $message->from('no-reply@site.com', "Dear");
                    $message->subject("Verify Account");
                    $message->to($data['email']);
            });

            session()->flash('success', "Vui lòng xác nhận tài khoản email");
            DB::commit();
        } catch (Exception $e){
            
            DB::rollBack();
            Log::error($e);
        }

        return redirect()->back();
    }

    public function verify(Request $request, $code)
    {
        $user = User::where('confirmation_code', $code);

        if($user->count() > 0){
            $user->update([
                'confirmed' => 1,
                'confirmation_code' => null
            ]);

            $status = "Xác nhận thành công, mời bạn đăng nhập !";
        }else{
            $status = "Xác nhận không thành công !";
        }

        return redirect()->route('shopping.login')->with('result_verify', $status);
    }

    public function logIn(Request $request)
    {
        
        if (!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'confirmed'=>1])) {

            session()->flash('error_login', "Vui lòng kiểm tra lại mật khẩu hoặc email !");
            return redirect()->back();
        }
        
        return redirect()->route('shopping.home');

        $validated = $request->validate([
            'email_login' => 'required',
            'password_login' => 'required',
        ]);

        session()->flash('error', 'Login failed');

        return redirect()->route('shopping.login');
    }

    public function logOut()
    {
        Auth::logout();

        session()->forget('cart');

        return redirect()->route('shopping.home');
    }
}
