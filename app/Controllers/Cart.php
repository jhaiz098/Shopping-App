<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use Config\Services;

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

        $quantity = (int) $this->request->getPost('quantity');

        if ($quantity < 1)
        {
            return redirect()->back()
                ->with('error', 'Invalid quantity.');
        }

        if ($quantity > $product['stock'])
        {
            return redirect()->back()
                ->with('error', 'Requested quantity exceeds available stock.');
        }

        $userId = session()->get('user_id');

        $existingCart = $cartModel
            ->where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if ($existingCart)
        {
            $newQuantity = $existingCart['quantity'] + $quantity;

            if ($newQuantity > $product['stock'])
            {
                return redirect()->back()
                    ->with(
                        'error',
                        'You already have ' .
                        $existingCart['quantity'] .
                        ' item(s) in your cart. Only ' .
                        $product['stock'] .
                        ' available.'
                    );
            }

            $cartModel->update($existingCart['id'], [
                'quantity' => $newQuantity
            ]);
        }
        else
        {
            $cartModel->insert([
                'user_id'    => $userId,
                'product_id' => $id,
                'quantity'   => $quantity
            ]);
        }

        return redirect()->back()
            ->with('success', 'Product added to cart.');
    }

    public function update_cart($id)
    {
        $cartModel = new CartModel();
        $productModel = new ProductModel();

        $cartItem = $cartModel->find($id);

        if (!$cartItem)
        {
            return redirect()->back()
                ->with('error', 'Cart item not found.');
        }

        $product = $productModel->find($cartItem['product_id']);

        if (!$product)
        {
            return redirect()->back()
                ->with('error', 'Product not found.');
        }

        $rules = [
            'quantity' => [
                'label' => 'Quantity',
                'rules' => 'required|integer|greater_than[0]'
            ]
        ];

        if (!$this->validate($rules))
        {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $quantity = (int) $this->request->getPost('quantity');

        // stock check (business rule validation)
        if ($quantity > $product['stock'])
        {
            return redirect()->back()
                ->with('error', 'Quantity exceeds available stock.');
        }

        $cartModel->update($id, [
            'quantity' => $quantity
        ]);

        return redirect()->back()
            ->with('success', 'Cart updated successfully.');
    }

    public function delete_cart($id)
    {
        $cartModel = new CartModel();

        $cartItem = $cartModel->find($id);

        if (!$cartItem)
        {
            return redirect()->back()
                ->with('error', 'Cart item not found.');
        }

        // Optional safety: ensure user can only delete their own cart item
        if ($cartItem['user_id'] != session()->get('user_id'))
        {
            return redirect()->back()
                ->with('error', 'Unauthorized action.');
        }

        $cartModel->delete($id);

        return redirect()->back()
            ->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $cartModel = new CartModel();

        $data['cartCount'] = $this->getCartCount();

        $cartItems = $cartModel
            ->select('
                carts.*,
                products.name,
                products.price,
                products.stock,
                products.image
            ')
            ->join('products', 'products.id = carts.product_id')
            ->where('carts.user_id', session()->get('user_id'))
            ->findAll();

        if (empty($cartItems)) {
            return redirect()->to('/cart')
                ->with('error', 'Your cart is empty.');
        }

        $hasInvalid = false;

        foreach ($cartItems as $item) {
            if ($item['quantity'] > $item['stock']) {
                $hasInvalid = true;
            }
        }

        if ($hasInvalid) {
            return redirect()->to('/cart')
                ->with('error', 'Some items exceed available stock. Please update your cart.');
        }

        $data['cartItems'] = $cartItems;

        return view('checkout', $data);
    }

    public function confirm_checkout()
    {
        $cartModel = new CartModel();
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $userId = session()->get('user_id');

        $cartItems = $cartModel
            ->where('user_id', $userId)
            ->findAll();

        if (empty($cartItems))
        {
            return redirect()->to('/cart')
                ->with('error', 'Cart is empty.');
        }

        $total = 0;

        foreach ($cartItems as $item)
        {
            $product = $productModel->find($item['product_id']);

            if ($item['quantity'] > $product['stock'])
            {
                return redirect()->to('/cart')
                    ->with('error', 'Not enough stock for ' . $product['name']);
            }

            $total += $product['price'] * $item['quantity'];
        }

        // 1. create order
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'total_amount' => $total,
            'status' => 'Pending',
            'order_date' => date('Y-m-d H:i:s')
        ]);

        // 2. insert order items + reduce stock
        foreach ($cartItems as $item)
        {
            $product = $productModel->find($item['product_id']);

            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product['price']
            ]);

            // reduce stock
            $productModel->update($product['id'], [
                'stock' => $product['stock'] - $item['quantity']
            ]);
        }

        // 3. clear cart
        $cartModel->where('user_id', $userId)->delete();

        return redirect()->to('/')
            ->with('success', 'Order placed successfully!');
    }

    public function getCartCount()
    {
        $cartModel = new CartModel();

        $cartCount = $cartModel
            ->where('user_id', session()->get('user_id'))
            ->countAllResults();

        return $cartCount;
    }
}