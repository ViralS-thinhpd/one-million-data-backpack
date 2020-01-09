<?php

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $authorData = array();
        for ($i = 1; $i <= 10000 ;$i++)
        {
            $authorData[] = array(
                'name' => $faker->name,
            );
        }
        Author::insert($authorData);
    }
}
