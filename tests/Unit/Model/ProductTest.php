<?php

namespace Tests\Unit\Model;

use App\Models\Product;
use App\TransferObject\ProductTransferObject;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testSoftDeleteProduct(): void
    {
        $product = Product::factory()->create();

        $this->assertTrue($this->isSoftDeletableModel($product));
    }

    public function testCreateProductFromTransferObject(): void
    {
        $product = Product::factory()->createFromTransferObject(
            ProductTransferObject::create('Test', 'test description', 14.00, 5)
        );

        $this->assertEquals('Test', $product->name);
        $this->assertEquals('test description', $product->description);
        $this->assertEquals(14.00, $product->price);
        $this->assertEquals(5, $product->stock);
    }
}
