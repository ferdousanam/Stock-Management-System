<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStocks = PurchaseItem::sum('quantity');
        return view('admin.home', compact('totalProducts', 'totalStocks'));
    }
}
