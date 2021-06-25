<?php

namespace Database\Seeders;

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
        $type = new Category();
        $type->name = "Interno";
        $type->save();

        $type1 = new Category();
        $type1->name = "Externo";
        $type1->save();
    }
}
