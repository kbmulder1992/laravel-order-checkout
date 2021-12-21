<?php

namespace Database\Seeders;

use App\Models\Product;
use App\TransferObject\ProductTransferObject;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ProductTransferObject::create('January Coffee Cup', 'A coffee cup for January', 10.99, 10),
            ProductTransferObject::create('February Coffee Cup', 'A coffee cup for February', 11.99, 15),
            ProductTransferObject::create('March Coffee Cup', 'A coffee cup for March', 12.99, 25),
            ProductTransferObject::create('April Coffee Cup', 'A coffee cup for April', 13.99, 30),
            ProductTransferObject::create('May Coffee Cup', 'A coffee cup for May', 14.99, 35),
            ProductTransferObject::create('June Coffee Cup', 'A coffee cup for June', 15.99, 40),
            ProductTransferObject::create('July Coffee Cup', 'A coffee cup for July', 16.99, 45),
            ProductTransferObject::create('August Coffee Cup', 'A coffee cup for August', 17.99, 50),
            ProductTransferObject::create('September Coffee Cup', 'A coffee cup for September', 18.99, 55),
            ProductTransferObject::create('October Coffee Cup', 'A coffee cup for October', 19.99, 60),
            ProductTransferObject::create('November Coffee Cup', 'A coffee cup for November', 20.99, 65),
            ProductTransferObject::create('December Coffee Cup', 'A coffee cup for December', 21.99, 70),
        ];

        /** @var ProductFactory $productFactory */
        $productFactory = Product::factory();

        foreach ($products as $product) {
            $productFactory->createFromTransferObject($product);
        }
    }
}
