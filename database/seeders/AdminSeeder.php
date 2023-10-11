<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            ['email' => 'admin@gmail.com', 'user_name' => 'admin', 'birthday' => '1999-02-02', 'first_name' => 'Admin', 'last_name' => 'Admin', 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['email' => 'abc@gmail.com', 'user_name' => 'abc456', 'birthday' => '1999-02-02', 'first_name' => 'Nguyên', 'last_name' => 'Lê Văn', 'password' => Hash::make('12345678'), 'reset_password' => '', 'status' => 'hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['email' => 'levana@gmail.com', 'user_name' => 'levana', 'birthday' => '1999-01-03', 'first_name' => 'A', 'last_name' => 'Lê Văn', 'password' => Hash::make('12345678'), 'reset_password' => 'hoạt động', 'status' => '', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['email' => 'levanb@gmail.com', 'user_name' => 'levanb', 'birthday' => '1999-01-03', 'first_name' => 'B', 'last_name' => 'Lê Văn', 'password' => Hash::make('12345678'), 'reset_password' => 'hoạt động', 'status' => '', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],         
        ];

        Admin::insert($admins);
    }
}
