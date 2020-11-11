<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'INCOME_1_SYSTEM',
                'type' => '1',
                'delete_active' => 1,
            ],
            [
                'name' => 'INCOME_2_SYSTEM',
                'type' => '1',
                'delete_active' => 1,
            ],
            [
                'name' => 'EXPENSE_1_SYSTEM',
                'type' => '0',
                'delete_active' => 1,
            ],
            [
                'name' => 'EXPENSE_2_SYSTEM',
                'type' => '0',
                'delete_active' => 1,
            ],
        ];
        \App\Models\Category::insert($data);
        //
    }
}
