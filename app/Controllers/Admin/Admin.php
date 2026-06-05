<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
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

        $data['categories'] = $categoryModel->findAll();

        return view('admin/categories.php', $data);
    }
}
