<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStocks = PurchaseItem::sum('quantity');
        $totalSales = SaleItem::sum('quantity');
        $latestFive['purchases'] = Purchase::latest()->limit(5)->get();
        $latestFive['sales'] = Sale::latest()->limit(5)->get();
        return view('admin.home', compact('totalProducts', 'totalStocks', 'totalSales', 'latestFive'));
    }
}
