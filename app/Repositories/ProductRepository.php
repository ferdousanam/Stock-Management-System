<?php


namespace App\Repositories;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;
    private $perPage;

    public function __construct(Product $product) {
        $this->product = $product;
        $this->perPage = 20;
    }

    public function paginate(Request $request)
    {
        $input = $request->all();
        $sql = $this->product
            ->select('products.*')
            ->addSelect('product_categories.title as product_category_title')
            ->addSelect('product_brands.title as product_brand_title')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->leftJoin('product_brands', 'product_brands.id', '=', 'products.product_brand_id')
            ->orderBy('id', 'desc');
        if (!empty($input['q'])) {
            $sql->where('title', 'LIKE', '%' . $input['q'] . '%');
        }
        if (!empty($input['product_brand_id'])) {
            $sql->where('product_brand_id', $input['product_brand_id']);
        }
        if (!empty($input['product_category_id'])) {
            $sql->where('product_category_id', $input['product_category_id']);
        }
        return $sql->paginate($this->perPage);
    }
}
