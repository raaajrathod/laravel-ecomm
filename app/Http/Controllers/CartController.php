<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $product_id)
    {
        $user = $request->user();

        // Find the product by ID
        $product = Product::findOrFail($product_id);

        // Check if the product is already in the cart
        $cartItem = $user->cartItems()->where('product_id', $product_id)->first();

        if ($cartItem) {
            // If the product is already in the cart, update the quantity
            $cartItem->increment('quantity');
        } else {
            // If the product is not in the cart, create a new cart item
            $cartItem = new CartItem([
                'product_id' => $product_id,
                'quantity' => 1,
            ]);
            $user->cartItems()->save($cartItem);
        }

        return response()->json([
            'message' => 'Product added to cart successfully.',
            'cart_item' => $cartItem,
        ], 200);
    }

}
