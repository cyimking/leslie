<?php

namespace Leslie\Http\Controllers\Product;

use Illuminate\Http\Request;
use Leslie\Http\Controllers\Controller;
use Leslie\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * ProductController constructor.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->products->paginate(10);

        return $request->isJson() ? response()->json($products) : view('layouts.app');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Not used...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Not used...
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return string
     */
    public function show($id, Request $request)
    {
        $product = $this->products->find($id);

        return $request->isJson() ? response()->json($product) : view('layouts.app');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Not used...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Not used...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Not used...
    }

    /**
     * Elastic Search function
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->all('q');
        $products = $this->products->search($query['q']);

        return response()->json($products);
    }
}
