<?php

namespace Leslie\Repositories\Product;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Collection;
use Leslie\Product;
use Leslie\ProductImage;

class EloquentProduct implements ProductRepository
{
    /**
     * @var Client
     */
    private $elasticsearch;

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage)
    {
        return Product::with('images')->paginate($perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return Product::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($productID)
    {
        return Product::with('images')->where('product_id', $productID)
            ->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $product = Product::create($data);

        if(isset($data['images'])) {
            foreach((array) $data['images'] as $image) {
                $product->images()->create([
                    'product_id' => $data['product_id'],
                    'path' => $image
                ]);
            }
        }

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function update($productID, array $data)
    {
        $product = $this->find($productID);
        $product->update($data);

        // TODO - Decouple into separate function
        if (isset($data['images'])) {
            foreach((array) $data['images'] as $imagePath) {
                $image1 = ProductImage::firstOrNew(
                    ['product_id' => $productID],
                    ['path' => $imagePath]
                );
                $product->images()->save($image1);
            }
        }

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($productID)
    {
        $product = $this->find($productID);

        return $product->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function search($query = '')
    {
        $this->elasticsearch = ClientBuilder::create()->build();      //TODO - Make static interface

        $items = $this->elasticsearch->search([
            'index' => 'products',
            'type' => 'products',
            'body' => [
                'query' => [
                    'query_string' => [
                        'query' => $query
                    ]
                ]
            ]
        ]);

        $results = $items['hits']['hits'];

        return Collection::make(array_map(function ($r) {
            $product = new Product();
            $product->newInstance($r['_source'], true);
            $product->setRawAttributes($r['_source'], true);
            return $product;
        }, $results));
    }
}