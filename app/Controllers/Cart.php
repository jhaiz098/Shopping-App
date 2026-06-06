<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;

class Cart extends BaseController
{
    public function add_to_cart($id)
    {
        if (!session()->get('isLoggedIn'))
        {
            return redirect()->to('/login')
                ->with('error', 'Please login first.');
        }

        $productModel = new ProductModel();
        $cartModel = new CartModel();

        $product = $productModel->find($id);

        if (!$product)
        {
            return redirect()->back()
                ->with('error', 'Product not found.');
        }

        $userId = session()->get('user_id');

        $existingCart = $cartModel
            ->where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if ($existingCart)
        {
            $cartModel->update($existingCart['id'], [
                'quantity' => $existingCart['quantity'] + 1
            ]);
        }
        else
        {
            $cartModel->insert([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()
            ->with('success', 'Product added to cart.');
    }
}