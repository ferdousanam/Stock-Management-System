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
            ->with(['category', 'brand'])
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
