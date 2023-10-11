<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Xe', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Điện thoại', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Phụ kiện', 'parent_id' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Áo', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],    
            ['name' => 'Quần', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],    
            ['name' => 'Kẹo', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],    
            ['name' => 'Thuốc', 'parent_id' => null, 'created_at' => date('Y-m-d H:i:s')],    
        ];
        Category::insert($categories);
    }
}
