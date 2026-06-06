<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Products extends BaseController
{
    public function add_product()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'category_id' => [
                'label' => 'Category',
                'rules' => 'required|integer'
            ],

            'name' => [
                'label' => 'Product Name',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],

            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[1000]'
            ],

            'price' => [
                'label' => 'Price',
                'rules' => 'required|decimal|greater_than_equal_to[0]'
            ],

            'stock' => [
                'label' => 'Stock',
                'rules' => 'required|integer|greater_than_equal_to[0]'
            ],

            'image' => [
                'label' => 'Product Image',
                'rules' => 'if_exist|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
            ]
        ];

        if (!$this->validate($rules))
        {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $productModel = new ProductModel();

        $image = $this->request->getFile('image');

        $imageName = null;

        if ($image && $image->isValid())
        {
            $imageName = $image->getRandomName();

            $image->move(
                FCPATH . 'uploads/products',
                $imageName
            );
        }

        $productModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image' => $imageName,
        ]);

        return redirect()->to('admin/products')
            ->with('success', 'Product added successfully.');
    }

    public function update_product($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product)
        {
            return redirect()->back()
                ->with('error', 'Product not found.');
        }

        $rules = [
            'category_id' => [
                'label' => 'Category',
                'rules' => 'required|integer'
            ],

            'name' => [
                'label' => 'Product Name',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],

            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[1000]'
            ],

            'price' => [
                'label' => 'Price',
                'rules' => 'required|decimal|greater_than_equal_to[0]'
            ],

            'stock' => [
                'label' => 'Stock',
                'rules' => 'required|integer|greater_than_equal_to[0]'
            ],

            'image' => [
                'label' => 'Product Image',
                'rules' => 'permit_empty|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
            ]
        ];

        if (!$this->validate($rules))
        {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');

        $imageName = $product['image'];

        if ($image && $image->isValid() && !$image->hasMoved())
        {
            $imageName = $image->getRandomName();

            $image->move(
                FCPATH . 'uploads/products',
                $imageName
            );

            if (!empty($product['image']))
            {
                $oldImage = FCPATH . 'uploads/products/' . $product['image'];

                if (file_exists($oldImage))
                {
                    unlink($oldImage);
                }
            }
        }

        $productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'image'       => $imageName,
        ]);

        return redirect()->to('admin/products')
            ->with('success', 'Product updated successfully.');
    }

    public function delete_product($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product)
        {
            return redirect()->back()
                ->with('error', 'Product not found.');
        }

        if (!empty($product['image']))
        {
            $imagePath = FCPATH . 'uploads/products/' . $product['image'];

            if (file_exists($imagePath))
            {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);

        return redirect()->to('admin/products')
            ->with('success', 'Product deleted successfully.');
    }
}