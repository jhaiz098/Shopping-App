<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\CartModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['cartCount'] = $this->getCartCount();
        
        $featuredLimit = 4;

        $data['products'] = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->orderBy('products.id', 'DESC')
            ->limit($featuredLimit)
            ->findAll();

        $data['categories'] = $categoryModel->findAll();

        return view('home', $data);
    }

    public function search()
    {
        $keyword = trim(
            $this->request->getGet('keyword')
        );

        $productModel = new ProductModel();

        $data['cartCount'] = $this->getCartCount();

        $data['keyword'] = $keyword;

        $data['products'] = $productModel
            ->like('name', $keyword)
            ->orLike('description', $keyword)
            ->findAll();

        return view('search_results', $data);
    }

    public function cart()
    {
        if (!session()->get('isLoggedIn'))
        {
            return redirect()->to('/login');
        }

        $cartModel = new CartModel();

        $data['cartCount'] = $this->getCartCount();

        $data['cartItems'] = $cartModel
            ->select('
                carts.*,
                products.name,
                products.price,
                products.image,
                products.stock
            ')
            ->join('products', 'products.id = carts.product_id')
            ->where('carts.user_id', session()->get('user_id'))
            ->findAll();

        return view('cart', $data);
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
