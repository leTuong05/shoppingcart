<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {
        $search = request()->input('search');
        $active = "users";
        $users = User::where('name', 'LIKE','%'.$search.'%')->paginate('20');

        return view('backend.users.index', compact('active', 'users', 'search'));
    }

    public function delete()
    {
        $id = request()->input('id');
        $isDeleted = User::where('id', $id)->delete();

        if ($isDeleted) {
            return [
                'status' => true
            ];
        }
        
        return ['status' => false];
    }
}
