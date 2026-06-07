<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\UserModel;

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
            ->where('products.stock >', 0)
            ->orderBy('products.id', 'DESC')
            ->limit($featuredLimit)
            ->findAll();

        foreach ($data['products'] as &$product)
        {
            $product['product_code'] =
                'PRD-' . str_pad($product['id'], 6, '0', STR_PAD_LEFT);
        }

        $data['categories'] = $categoryModel
            ->limit(4)
            ->findAll();

        return view('home', $data);
    }

    public function search()
    {
        $keyword = trim($this->request->getGet('keyword'));
        $categoryId = $this->request->getGet('category');

        $productModel = new ProductModel();
        $cartModel = new CartModel();
        $categoryModel = new CategoryModel();

        $userId = session()->get('user_id');

        $cartItems = $cartModel
            ->where('user_id', $userId)
            ->findAll();

        $cartMap = [];

        foreach ($cartItems as $item)
        {
            $cartMap[$item['product_id']] = $item['quantity'];
        }

        $perPage = 8;

        $builder = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');

        // Category filter
        if (!empty($categoryId))
        {
            $builder->where(
                'products.category_id',
                $categoryId
            );
        }

        // Keyword filter
        if (!empty($keyword))
        {
            $builder
                ->groupStart()
                    ->like('products.name', $keyword)
                    ->orLike('products.description', $keyword)
                ->groupEnd();
        }

        $products = $builder
            ->orderBy('products.id', 'DESC')
            ->paginate($perPage);

        foreach ($products as &$product)
        {
            $product['product_code'] =
                'PRD-' . str_pad(
                    $product['id'],
                    6,
                    '0',
                    STR_PAD_LEFT
                );
        }

        $data = [
            'cartMap'       => $cartMap,
            'cartCount'     => $this->getCartCount(),
            'keyword'       => $keyword,
            'categoryId'    => $categoryId,
            'products'      => $products,
            'pager'         => $productModel->pager,
            'categories'    => $categoryModel->findAll()
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

    public function profile()
    {
        if (!session()->get('isLoggedIn'))
        {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();

        $data['user'] = $userModel->find(
            session()->get('user_id')
        );

        $data['cartCount'] = $this->getCartCount();

        return view('profile', $data);
    }

    public function update_profile()
    {
        $userModel = new UserModel();

        $userId = session()->get('user_id');

        $userModel->update($userId, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email')
        ]);

        session()->set([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name')
        ]);

        return redirect()->back()
            ->with('success', 'Profile updated successfully.');
    }
}
