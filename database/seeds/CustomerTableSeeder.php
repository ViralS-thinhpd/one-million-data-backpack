<?php

use App\Models\Book;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $customerData = array();
        for ($i = 1; $i <= 10000 ;$i++)
        {
            $customerData[] = array(
                'name' => $faker->name,
                'age' => $faker->numberBetween(10, 60),
                'address' => $faker->address,
            );
        }
        Customer::insert($customerData);
        $books = Book::all()->count();
        $customers = Customer::all()->count();
        $bookCustomer = array();
        for ($i = 1; $i <= 10000 ;$i++)
        {
            $bookCustomer[] = array(
                'book_id' => $faker->numberBetween(1, $books),
                'customer_id' => $faker->numberBetween(1, $customers),
            );
        }
        DB::table('book_customer')->insert($bookCustomer);
    }
}
