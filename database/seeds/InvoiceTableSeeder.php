<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\InvoiceProduct;
use App\bill;
class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        bill::truncate();
        InvoiceProduct::truncate();

        foreach (range(1, 20) as $i) {
            $products = collect();
            foreach (range(1, mt_rand(2, 10)) as $j) {
                $unitPrice = $faker->numberBetween(100, 1000);
                $qty = $faker->numberBetween(1, 20);
                $products->push(new InvoiceProduct([
                    'name' => $faker->sentence,
                    'price' => $unitPrice,
                    'qty' => $qty,
                    'total' => ($qty * $unitPrice)
                ]));
            }
            $subTotal = $products->sum('total');
            $discount = $faker->numberBetween(10, 20);
            //recheck $grandTotal
            $total = $subTotal - $discount;

            $invoice = bill::create([
                'client' => $faker->name,
                'client_address' => $faker->address,
                'title' => $faker->sentence,
                'invoice_no' => $faker->numberBetween(100000, 40000),
                'invoice_date' => $faker->date(),
                'due_date' => $faker->date(),
                'discount' => $discount,
                'sub_total' => $subTotal,
                'grand_total' => $total
            ]);

            $invoice->products()->saveMany($products);
        }
    }

}
