<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::insert([
            'name'=>'admin',
            'email'=>'vantuong@gmail.com',
            'password'=>'12345',
        ]);
    }
}
