<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [ 'phone'=>0123123123,'email' => 'nhattan@gmail.com', 'birthday' => '1999-02-02',  'full_name' => 'Lê Nhật Tân','address'=>43,'province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['phone'=>0123123125, 'email' => 'nhattam@gmail.com',  'birthday' => '1999-02-02',  'full_name' => 'Lê Nhật Tâm','address'=>43,'province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'phone'=>0123123126,'email' => 'nguyenvanphu@gmail.com',  'birthday' => '1999-02-02',  'full_name' => 'Nguyễn Văn Phú','address'=>43,'province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['phone'=>0123123127, 'email' => 'phanvantai@gmail.com',  'birthday' => '1999-02-02', 'full_name' => 'Phan Văn Tài','address'=>43,'province_id'=>1,'district_id'=>1,'commune_id'=>1, 'password' => Hash::make('123123123'), 'reset_password' => '', 'status' => 'Hoạt động', 'flag_delete' => 0, 'created_at' => date('Y-m-d H:i:s')],        
        ];
        Customer::insert($customers);
    }
}
