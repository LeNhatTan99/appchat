<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [ 'sku' => 'PRD012388', 'name' => 'Xe máy','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 1, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD012389', 'name' => 'Xe máy điện','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 1, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD012381', 'name' => 'Xe đạp','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 1, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD012321', 'name' => 'Xe ô tô','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 1, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD012332', 'name' => 'Máy tính','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 2, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD0123828', 'name' => 'Điện thoại','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 2, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD0123288', 'name' => 'Sạc','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 2, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD0123898', 'name' => 'Tai nghe','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 2, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD01238822', 'name' => 'Loa','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 3, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD01238a8', 'name' => 'Bàn phím','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 3, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
            [ 'sku' => 'PRD01238228', 'name' => 'Chuột','price'=> 2000000 ,'stock' => 16, 'avatar' => '', 'expired_at' => date('Y-m-d'), 'category_id' => 3, 'flag_delete' =>0, 'created_at' => date('Y-m-d H:i:s')],
                 
        ];
        Product::insert($products);
    }
}
