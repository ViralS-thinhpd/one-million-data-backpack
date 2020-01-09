<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\User::truncate();
        \App\Models\Author::truncate();
        \App\Models\Book::truncate();
        \App\Models\Customer::truncate();
        \Illuminate\Support\Facades\DB::table('book_customer')->truncate();
        $this->call(UsersTableSeeder::class);
        for ($i = 1; $i <= 100; $i++ )
        {
            $this->call(AuthorTableSeeder::class);
            $this->call(BookTableSeeder::class);
            $this->call(CustomerTableSeeder::class);
        }
    }
}
