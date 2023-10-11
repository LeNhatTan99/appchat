<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['email' => 'nhattan@gmail.com', 'user_name' => 'nhattan', 'birthday' => '1999-02-02', 'first_name' => 'Tân', 'last_name' => 'Lê Nhật','address'=>'21','province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'email' => 'nhattam@gmail.com', 'user_name' => 'nhattam', 'birthday' => '1999-02-02', 'first_name' => 'Tâm', 'last_name' => 'Lê Nhật','address'=>'21','province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'email' => 'nguyenvanphu@gmail.com', 'user_name' => 'nguyenvanphu', 'birthday' => '1999-02-02', 'first_name' => 'Phú', 'last_name' => 'Nguyễn Văn','address'=>'21','province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['email' => 'phanvantai@gmail.com', 'user_name' => 'phanvantai', 'birthday' => '1999-02-02', 'first_name' => 'Tài', 'last_name' => 'Phan Văn','address'=>'21','province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],        
        ];
        User::insert($users);
    }
}
