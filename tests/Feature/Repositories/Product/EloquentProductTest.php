<?php
/**
 * TODO - Updating test cases to cover at 90% of the Repository
 */
namespace Tests\Feature\Repositories\Product;

use Leslie\Product;
use Leslie\Repositories\Product\EloquentProduct;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var EloquentProduct
     */
    protected $eloquentRepo;


    public function setUp() : void
    {
        parent::setUp();
        $this->eloquentRepo = app(EloquentProduct::class);
    }

    /**
     * Test find() function
     */
    public function test_find(): void
    {
        $product = factory(Product::class)->create();

        // Check for a valid product
        $this->assertArraySubset(
            $product->toArray(),
            $this->eloquentRepo->find($product->product_id)->toArray()
        );

        // Check for a invalid product
        $this->assertNull($this->eloquentRepo->find(5144));
    }

    /**
     * Test create() function
     */
    public function test_create(): void
    {
        $product = factory(Product::class)->make()->toArray();
        $this->eloquentRepo->create($product);

        // Check if create() was successful
        $this->assertDatabaseHas('products', $product);
    }

    /**
     * Test update() function
     */
    public function test_update(): void
    {
        $product = factory(Product::class)->create();
        $newData = [
            'brand' => 'Mega Storm'
        ];
        $this->eloquentRepo->update($product->product_id, $newData);

        // Check if the product's brand was updated
        $this->assertDatabaseHas('products', $newData + ['product_id' => $product->product_id]);
    }

    /**
     * Test delete() function
     */
    public function test_delete(): void
    {
        // Create -> insert product into database
        $product = factory(Product::class)->create();

        // Delete from database
        $this->eloquentRepo->delete($product->product_id);

        // Check if the lead is missing from the DB
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
