<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $categoryModel = new CategoryModel;
        $productModel  = new ProductModel;
        $orderModel    = new OrderModel;
        $userModel     = new UserModel;

        $data = [
            'categoriesCount' => $categoryModel->countAllResults(),
            'productsCount'   => $productModel->countAllResults(),
            'ordersCount'     => $orderModel->countAllResults(),
            'usersCount'      => $userModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    public function categories()
    {
        $categoryModel = new CategoryModel();

        $perPage = 10;

        $data = [
            'categories' => $categoryModel->paginate($perPage),
            'pager'      => $categoryModel->pager,
        ];

        return view('admin/categories', $data);
    }

    public function products()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['products'] = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->orderBy('products.id', 'DESC')
            ->paginate(10);

        $data['pager'] = $productModel->pager;

        $data['categories'] = $categoryModel
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('admin/products', $data);
    }

    public function orders()
    {
        $orderModel = new OrderModel();

        $data['orders'] = $orderModel
            ->select('orders.*, users.first_name, users.last_name, users.email')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.order_date', 'DESC')
            ->paginate(10);

        $data['pager'] = $orderModel->pager;

        return view('admin/orders', $data);
    }

    public function users()
    {
        $userModel = new \App\Models\UserModel();

        $data['users'] = $userModel
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $data['pager'] = $userModel->pager;

        return view('admin/users', $data);
    }
}
