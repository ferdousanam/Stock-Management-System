<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;
    private $perPage;
    private $warehouse_id;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->perPage = 20;
    }

    public function filterByWarehouse(int $warehouse_id): ProductRepository
    {
        $this->warehouse_id = $warehouse_id;

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function addSelectProductQty($query)
    {
        $remaining_items = DB::query()->fromSub($this->productPurchaseQuery(), 'purchase_items')
            ->when(!$this->warehouse_id, function (\Illuminate\Database\Query\Builder $q) {
                $q->select('purchase_items.product_id', DB::raw("IFNULL(purchase_quantity, 0) - IFNULL(sale_quantity, 0) as remaining_qty"));
            })
            ->when($this->warehouse_id, function (\Illuminate\Database\Query\Builder $q) {
                $q->select('purchase_items.product_id', DB::raw("IFNULL(purchase_quantity, 0) - IFNULL(sale_quantity, 0) - IFNULL(transfer_quantity, 0) as remaining_qty"))
                    ->joinSub($this->productTransferredQuery(), 'p_transfer', 'p_transfer.product_id', '=', 'purchase_items.product_id', 'left');
            })
            ->joinSub($this->productSaleQuery(), 'sale_items', 'sale_items.product_id', '=', 'purchase_items.product_id', 'left');

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
            $sql->where('products.title', 'LIKE', '%' . $input['q'] . '%')
                ->orWhere('products.product_code', 'LIKE', '%' . $input['q'] . '%');
        }
        if (!empty($input['product_brand_id'])) {
            $sql->where('product_brand_id', $input['product_brand_id']);
        }
        if (!empty($input['product_category_id'])) {
            $sql->where('product_category_id', $input['product_category_id']);
        }
        return $sql->paginate($this->perPage);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function productPurchaseQuery()
    {
        return PurchaseItem::select('product_id', DB::raw("SUM(quantity) as purchase_quantity"))
            ->where('purchasable_type', '<>', Transfer::class)
            ->when($this->warehouse_id, function (Builder $q) {
                $q->where('warehouse_id', $this->warehouse_id);
            })
            ->groupBy('product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function productSaleQuery()
    {
        return SaleItem::select('product_id', DB::raw("SUM(quantity) as sale_quantity"))
            ->when($this->warehouse_id, function (Builder $q) {
                $q->where('warehouse_id', $this->warehouse_id);
            })
            ->groupBy('product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function productTransferredQuery()
    {
        return PurchaseItem::selectRaw("product_id, ifnull(sum(quantity), 0) as transfer_quantity")
            ->join('transfers', 'transfers.id', '=', 'purchasable_id')
            ->where('purchasable_type', Transfer::class)
            ->groupBy('product_id')
            ->when($this->warehouse_id, function (Builder $q) {
                $q->where('from_warehouse_id', $this->warehouse_id);
            });
    }
}
