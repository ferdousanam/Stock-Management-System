<?php


namespace App\Repositories;


use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\Transfer;
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
            ->addSelect(DB::raw("ifnull(sum(purchase_items.quantity), 0) as purchase_total"))
            ->addSelect(DB::raw("ifnull(sum(sale_items.quantity), 0) as sale_total"))
            ->leftJoin('product_brands', 'products.product_brand_id', '=', 'product_brands.id')
            ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('purchase_items', 'products.id', '=', 'purchase_items.product_id')
            ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->where('purchasable_type', '!=', Transfer::class);
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
            ->groupBy('purchase_items.product_id')
            ->orderBy('products.title');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function productTransferredQuery()
    {
        return PurchaseItem::selectRaw("product_id, ifnull(sum(purchase_items.quantity), 0) as transferred_total")
            ->join('transfers', 'transfers.id', '=', 'purchase_items.purchasable_id')
            ->where('purchasable_type', Transfer::class)
            ->groupBy('purchase_items.product_id')
            ->where('from_warehouse_id', $this->warehouse_id);
    }

    private function warehouseIdQuery()
    {
        if ($this->warehouse_id) {
            return $this->builder->where('purchase_items.warehouse_id', $this->warehouse_id)
                ->addSelect(DB::raw("ifnull(sum(purchase_items.quantity), 0) - ifnull(sum(sale_items.quantity), 0) - ifnull(transferred_total, 0) as stock_total"))
                ->joinSub($this->productTransferredQuery(), 'p_transfer', 'p_transfer.product_id', '=', 'purchase_items.product_id', 'left');
        }
        return $this->builder->addSelect(DB::raw("ifnull(sum(purchase_items.quantity), 0) - ifnull(sum(sale_items.quantity), 0) as stock_total"));
    }
}
