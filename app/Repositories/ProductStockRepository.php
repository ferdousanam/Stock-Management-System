<?php


namespace App\Repositories;


use App\Models\Product;

class ProductStockRepository
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product) {
        $this->product = $product::selectRaw("products.*, product_categories.title as category, product_brands.title as brand, sum(purchase_items.quantity) as purchase_total")
            ->leftJoin('product_brands', 'products.product_brand_id', '=', 'product_brands.id')
            ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('purchase_items', 'products.id', '=', 'purchase_items.product_id')
            ->groupBy('purchase_items.product_id')
            ->orderBy('products.title');;
    }

    public function getSql()
    {
        return $this->product;
    }
}
