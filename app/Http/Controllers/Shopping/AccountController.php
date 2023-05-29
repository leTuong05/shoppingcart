<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shopping\UpdateUserValidator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::select('name', 'phone_number', 'email', 'avatar')->where('id', auth()->user()->id)->first();
        return view('shopping.pages.shop.account', compact(['user']));
    }

    public function update(UpdateUserValidator $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            
            if ($request->hasFile('avatar')) {
                $file = $params['avatar'];
                $path = Storage::putFileAs('user-avatars', $file, $file->getClientOriginalName());
                
                User::where('id', auth()->user()->id)
                ->update([
                    'name' => $params['name'],
                    'phone_number' => $params['phone_number'],
                    'avatar' => $path
                ]);
            } else {
                User::where('id', auth()->user()->id)
                ->update([
                    'name' => $params['name'],
                    'phone_number' => $params['phone_number'],
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with(['messages_error'=>'Đã xảy ra lỗi khi cập nhật thông tin, xin thử lại!']);
        }
        
        return redirect()->route('shopping.accounts.index')->with('messages_success', 'Cập nhật thông tin thành công');
    }
}
