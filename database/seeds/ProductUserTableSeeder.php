<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $user = User::find(61);
        $faker = Faker\Factory::create();
        foreach ($products as $p) {
            $user->products()
                ->syncWithoutDetaching([$p->id => ['quantity' => $faker->numberBetween($min = 0, $max = 60)]]);
        }
    }
}
