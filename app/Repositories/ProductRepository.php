<?php


namespace App\Repositories;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;
    private $perPage;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->perPage = 20;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Expression $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function addSelectProductQty($query)
    {
        $purchase_items = DB::table('purchase_items')
            ->select('product_id', DB::raw("SUM(quantity) as purchase_quantity"))
            ->groupBy('product_id');

        $sale_items = DB::table('sale_items')
            ->select('product_id', DB::raw("SUM(quantity) as sale_quantity"))
            ->groupBy('product_id');

        $remaining_items = DB::query()->fromSub($purchase_items, 'purchase_items')
            ->select('purchase_items.product_id', DB::raw("IFNULL(purchase_quantity, 0) - IFNULL(sale_quantity, 0) as remaining_qty"))
            ->joinSub($sale_items, 'sale_items', 'sale_items.product_id', '=', 'purchase_items.product_id', 'left');

        $query->addSelect(DB::raw("IFNULL(remaining_qty, 0) as remaining_quantity"));
        $query->joinSub($remaining_items, 'remaining_items', 'remaining_items.product_id', '=', 'products.id', 'left');

        return $query;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
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
        $sql = $this->addSelectProductQty($sql);
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
