<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function getSql(Request $request)
    {
        $builder = Product::query();
        if ($request->q) {
            $builder->where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('product_code', 'LIKE', '%' . $request->q . '%');
        }
        return $builder;
    }

    public function index(Request $request)
    {
        $products = $this->getSql($request)->get();
        if ($products) {
            return response()->json(['success' => true, 'data' => $products]);
        }
        return response()->json(['success' => false, 'message' => 'Product Not Found.']);
    }

    public function suggestions(Request $request)
    {
        $products = $this->getSql($request)->limit(5)->get();
        if ($products) {
            return response()->json(['success' => true, 'data' => $products]);
        }
        return response()->json(['success' => false, 'message' => 'Product Not Found.']);
    }
}
