<?php

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
use Config\Services;
use App\Controllers\BaseController;
use App\Models\ProductModel;

class Categories extends BaseController
{
    public function add_category()
    {
        $validation = Services::validation();

        $rules = [
            'name' => [
                'label'  => 'Category Name',
                'rules'  => 'required|min_length[2]|max_length[100]',
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[255]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('admin/categories')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $categoryModel = new CategoryModel();

        $categoryModel->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('admin/categories')
            ->with('success', 'Category added successfully.');
    }

    public function update_category($id)
    {
        $validation = Services::validation();

        $rules = [
            'name' => [
                'label'  => 'Category Name',
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'    => 'Category name is required.',
                    'min_length'  => 'Category name must be at least 2 characters.',
                    'max_length'  => 'Category name must not exceed 100 characters.'
                ]
            ],
            'description' => [
                'label'  => 'Description',
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Description must not exceed 255 characters.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $categoryModel = new CategoryModel();

        $categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('admin/categories')
            ->with('success', 'Category updated successfully.');
    }

    public function delete_category($id)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();

        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('admin/categories')
                ->with('error', 'Category not found.');
        }

        $hasProducts = $productModel
            ->where('category_id', $id)
            ->countAllResults();

        if ($hasProducts > 0)
        {
            return redirect()->back()
                ->with(
                    'error',
                    'Cannot delete category because products are assigned to it.'
                );
        }

        $categoryModel->delete($id);

        return redirect()->to('admin/categories')
            ->with('success', 'Category deleted successfully.');
    }
}
