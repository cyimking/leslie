<?php

use Illuminate\Database\Seeder;
use Leslie\Product;
use Leslie\ProductImage;

class ProductImageTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultProductID = 2170;

        $defaultImages = [
            'http://edc.poolsupplyworld.com/wimages/product_image/f5_001.jpg',
            'http://edc.poolsupplyworld.com/wimages/product_image/f5_002.jpg',
            'http://edc.poolsupplyworld.com/wimages/product_image/f5_003.jpg',
            'http://edc.poolsupplyworld.com/wimages/product_image/f5_004.jpg',
            'http://edc.poolsupplyworld.com/wimages/product_image/f5_005.jpg',
            'http://edc.poolsupplyworld.com/wimages/product_image/g5_67882.jpg'
        ];

        $product = (new Product)->find(1);

        foreach ($defaultImages as $image) {
            $imageObject = new ProductImage;
            $imageObject->path = $image;
            $imageObject->product_id = $defaultProductID;
            $product->images()->save($imageObject);
        }

        $images = factory(ProductImage::class)->times(20)->create();
    }
}
