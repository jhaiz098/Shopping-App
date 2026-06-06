<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard.php');
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
}
