<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductStockRepository
{
    /**
     * @var Product
     */
    private $builder;
    private $warehouse_id;

    public function __construct(Product $product) {
        $this->builder = $product::selectRaw("products.*, product_categories.title as category, product_brands.title as brand")
            ->addSelect(DB::raw("ifnull(purchase_items.quantity, 0) as purchase_total"))
            ->addSelect(DB::raw("ifnull(sale_items.quantity, 0) as sale_total"))
            ->leftJoin('product_brands', 'products.product_brand_id', '=', 'product_brands.id')
            ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id');
    }

    public function filterByWarehouse(int $warehouse_id): ProductStockRepository
    {
        $this->warehouse_id = $warehouse_id;

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function getSql(): \Illuminate\Database\Eloquent\Builder
    {
        $this->warehouseIdQuery();

        return $this->builder
            ->leftJoinSub($this->productPurchaseQuery(), 'purchase_items', 'products.id', '=', 'purchase_items.product_id')
            ->leftJoinSub($this->productSaleQuery(), 'sale_items', 'products.id', '=', 'sale_items.product_id')
            ->orderBy('products.title');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function productPurchaseQuery()
    {
        return PurchaseItem::selectRaw("product_id, ifnull(sum(quantity), 0) as quantity")
            ->where('purchasable_type', '!=', Transfer::class)
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
        return SaleItem::selectRaw("product_id, ifnull(sum(quantity), 0) as quantity")
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
        return PurchaseItem::selectRaw("product_id, ifnull(sum(quantity), 0) as quantity")
            ->join('transfers', 'transfers.id', '=', 'purchasable_id')
            ->where('purchasable_type', Transfer::class)
            ->groupBy('product_id')
            ->when($this->warehouse_id, function (Builder $q) {
                $q->where('from_warehouse_id', $this->warehouse_id);
            });
    }

    private function warehouseIdQuery()
    {
        if ($this->warehouse_id) {
            return $this->builder->addSelect(DB::raw("ifnull(purchase_items.quantity, 0) - ifnull(sale_items.quantity, 0) - ifnull(p_transfer.quantity, 0) as stock_total"))
                ->joinSub($this->productTransferredQuery(), 'p_transfer', 'p_transfer.product_id', '=', 'products.id', 'left');
        }
        return $this->builder->addSelect(DB::raw("ifnull(purchase_items.quantity, 0) - ifnull(sale_items.quantity, 0) as stock_total"));
    }
}
