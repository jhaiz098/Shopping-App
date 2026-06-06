<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\OrderModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $cartModel = new CartModel();

        $userId = session()->get('user_id');

        $cartItems = $cartModel
            ->where('user_id', $userId)
            ->findAll();

        $cartMap = [];

        foreach ($cartItems as $item)
        {
            $cartMap[$item['product_id']] = $item['quantity'];
        }

        $data['cartMap'] = $cartMap;

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
        $keyword = trim($this->request->getGet('keyword'));

        $productModel = new ProductModel();
        $cartModel    = new CartModel();

        $userId = session()->get('user_id');

        // CART MAP (for showing quantities in UI)
        $cartItems = $cartModel
            ->where('user_id', $userId)
            ->findAll();

        $cartMap = [];

        foreach ($cartItems as $item) {
            $cartMap[$item['product_id']] = $item['quantity'];
        }

        $perPage = 8;

        $builder = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.description', $keyword)
            ->groupEnd()
            ->orderBy('products.id', 'DESC');

        $data = [
            'cartMap'  => $cartMap,
            'cartCount'=> $this->getCartCount(),
            'keyword'  => $keyword,
            'products' => $builder->paginate($perPage),
            'pager'    => $productModel->pager
        ];

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


    public function my_orders()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();

        $data['cartCount'] = $this->getCartCount();

        $data['orders'] = $orderModel
            ->where('user_id', session()->get('user_id'))
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('my_orders', $data);
    }
}
