<?php

namespace Leslie\Repositories\Product;

interface ProductRepository
{
    /**
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage);

    /**
     * @param $productID
     * @return mixed
     */
    public function find($productID);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $productID
     * @param array $data
     * @return mixed
     */
    public function update($productID, array $data);

    /**
     * @param $productID
     * @return mixed
     */
    public function delete($productID);
}