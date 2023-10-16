<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->url = env('PRODUCT_SERVICE_URL');
        $this->token = env('PRODUCT_SERVICE_TOKEN');
        $this->version = env('PRODUCT_SERVICE_VERSION');

        $this->http = Http::withToken($this->token);
        $this->href = $this->url . '/' . $this->version . '/products';
    }


    // Get All Products
    public function index(Request $request)
    {
        $url = "{$this->href}";

        return $this->http->get($url);
    }

    public function store(Request $request): PromiseInterface|Response
    {
        $url = "{$this->href}";

        return $this->http->post($url);
    }

    public function show(Request $request, $product_id): PromiseInterface|Response
    {

        $url = "{$this->href}/{$product_id}";

        return $this->http->get($url);
    }
}
