<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private function filter(Builder $builder, Request $request)
    {
        if (!empty($request->input('q'))) {
            $builder->where(function (Builder $sql) use ($request) {
                $sql->where('products.title', 'LIKE', '%' . $request->input('q') . '%')
                    ->orWhere('products.product_code', 'LIKE', '%' . $request->input('q') . '%');
            });
        }
        return $builder;
    }

    public function index(Request $request)
    {
        $products = $this->filter(Product::query(), $request)->get();
        if ($products) {
            return response()->json(['success' => true, 'data' => $products]);
        }
        return response()->json(['success' => false, 'message' => 'Product Not Found.']);
    }

    public function suggestions(Request $request, ProductRepository $productRepository)
    {
        if ($request->input('warehouse')) {
            $productRepository->filterByWarehouse($request->input('warehouse'));
        }

        $sql = $productRepository->addSelectProductQty($this->filter(Product::select('products.*'), $request))->limit(5);

        if ($request->input('inStock') == 1) {
            $sql->where(DB::raw('IFNULL(remaining_qty, 0)'), '>', 0);
        }

        $products = $sql->get();
        if ($products) {
            return response()->json(['success' => true, 'data' => $products]);
        }
        return response()->json(['success' => false, 'message' => 'Product Not Found.']);
    }
}
