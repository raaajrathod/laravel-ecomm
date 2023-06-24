<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    //

    public function index(Request $request): JsonResponse
    {
        $products = Product::all();
        return response()->json($products);
    }
}
