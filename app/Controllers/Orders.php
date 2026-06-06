<?php

namespace App\Controllers;

use App\Models\OrderItemModel;
use App\Models\CartModel;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function getCartCount()
    {
        $cartModel = new CartModel();

        $cartCount = $cartModel
            ->where('user_id', session()->get('user_id'))
            ->countAllResults();

        return $cartCount;
    }


    public function my_orders()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();

        $userId = session()->get('user_id');

        $perPage = 10;

        $data['cartCount'] = $this->getCartCount();

        $data['orders'] = $orderModel
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate($perPage);

        foreach ($data['orders'] as $key => &$order)
        {
            $data['orders'][$key]['order_code'] = 'ORD-' . str_pad($order['id'], 6, '0', STR_PAD_LEFT);
        }

        $data['pager'] = $orderModel->pager;

        return view('my_orders', $data);
    }

    public function view_order($id)
    {
        $orderModel = new OrderModel();

        $order = $orderModel
            ->select('orders.*, users.first_name, users.last_name')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.id', $id)
            ->first();

        $order_code = 'ORD-' . str_pad($order['id'], 6, '0', STR_PAD_LEFT);

        if (!$order)
        {
            return redirect()->to('orders/my')
                ->with('error', 'Order not found.');
        }

        $orderItemModel = new OrderItemModel();

        $items = $orderItemModel
            ->select('order_items.*')
            ->where('order_items.order_id', $id)
            ->findAll();

        return view('orders_view', [
            'order' => $order,
            'items' => $items,
            'cartCount' => $this->getCartCount(),
            'order_code' => $order_code
        ]);
    }
}