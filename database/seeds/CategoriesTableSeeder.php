<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create(['name' => 'Coffee Products']);
        ProductCategory::create(['name' => 'Ready to Drink Coffee']);
        ProductCategory::create(['name' => 'Snacks & Cookies']);
        ProductCategory::create(['name' => 'Merchandise']);
    }
}
