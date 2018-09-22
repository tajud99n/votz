<?php

use App\Category;
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
        $c1 = [
            'category' => 'Entertainment',
            'slug'     => str_slug('Entertainment')
        ];

        $c2 = [
            'category'  => 'Sports',
            'slug'      => str_slug('Sports')
        ];

        $c3 = [
            'category'  => 'Fashion',
            'slug'      => str_slug('Fashion')
        ];

        $c4 = [
            'category'  => 'General',
            'slug'      => str_slug('General')
        ];

        Category::create($c1);
        Category::create($c2);
        Category::create($c3);
        Category::create($c4);
    }
}
