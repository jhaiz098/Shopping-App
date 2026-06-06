<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function update_order($id)
    {
        $orderModel = new OrderModel();

        $order = $orderModel->find($id);

        if (!$order)
        {
            return redirect()->back()
                ->with('error', 'Order not found.');
        }

        $status = $this->request->getPost('status');

        $allowedStatuses = [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
        ];

        if (!in_array($status, $allowedStatuses))
        {
            return redirect()->back()
                ->with('error', 'Invalid status.');
        }

        $orderModel->update($id, [
            'status' => $status
        ]);

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }
}