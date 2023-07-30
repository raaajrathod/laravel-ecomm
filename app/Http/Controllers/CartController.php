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

    public function removeFromCart(Request $request, $product_id)
    {
        $user = $request->user();

        // Find the product by ID
        $product = Product::findOrFail($product_id);

        // Find the cart item for the product in the user's cart
        $cartItem = $user->cartItems()->where('product_id', $product_id)->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Product not found in cart.',
            ], 404);
        }

        // Delete the cart item for the product
        $cartItem->delete();

        return response()->json([
            'message' => 'Product removed from cart successfully.',
        ], 200);
    }

    public function getCartItems(Request $request)
    {
        $user = $request->user();

        // Retrieve all cart items for the user with related product details (name, image, etc.)
        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product:id,name,images')
            ->get(['id', 'product_id', 'quantity']);

        return response()->json([
            'cart_items' => $cartItems,
        ], 200);
    }

    public function updateCartItem(Request $request, $product_id)
    {
        $user = $request->user();

        // Find the product by ID
        $product = Product::findOrFail($product_id);

        // Find the cart item for the product in the user's cart
        $cartItem = $user->cartItems()->where('product_id', $product_id)->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Product not found in cart.',
            ], 404);
        }

        // Validate and update the quantity
        $quantity = $request->input('quantity');

        if (!is_numeric($quantity) || $quantity <= 0) {
            return response()->json([
                'message' => 'Invalid quantity provided. Quantity should be a positive number.',
            ], 400);
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return response()->json([
            'message' => 'Cart item updated successfully.',
            'cart_item' => $cartItem,
        ], 200);
    }


}
