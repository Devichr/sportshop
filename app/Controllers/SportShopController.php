<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BannerModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\SearchHistoryModel;
use App\Libraries\TFIDFCalculator;
use CodeIgniter\Controller;

class SportShopController extends BaseController
{
    protected $productModel;
    protected $bannerModel;
    protected $categoryModel;
    protected $cartModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;
    protected $searchHistoryModel;
    protected $tfidfCalculator;


    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->bannerModel = new BannerModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->searchHistoryModel = new SearchHistoryModel();
        $this->tfidfCalculator = new TFIDFCalculator();
    }
    

    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
        $products = $this->productModel->findAll();
        
        // Mendapatkan data banner
        $data['banners'] = $this->bannerModel->findAll();

        // Mendapatkan produk favorit pengguna jika login
        $recommendedProducts = [];

        if ($userId) {
            $user = $this->userModel->find($userId);
            $favouriteSport = $user['favorite_sport'];

            $products = $this->productModel->findAll();
            $docs = array_map(function($product) {
                return $product['description'];
            }, $products);

            // Initialize TF-IDF scores
            foreach ($products as &$product) {
                $product['tfidf'] = 1;
            }

            // Calculate TF-IDF for favorite sport
            foreach ($products as &$product) {
                $product['tfidf'] += $this->tfidfCalculator->calculateTFIDF($favouriteSport, $product['description'], $docs);
            }

            // Calculate TF-IDF for search history
            $searchHistory = $this->searchHistoryModel->where('user_id', $userId)->orderBy('searched_at', 'DESC')->findAll();
            foreach ($searchHistory as $search) {
                $searchTerm = $search['search_term'];
                foreach ($products as &$product) {
                    $product['tfidf'] += $this->tfidfCalculator->calculateTFIDF($searchTerm, $product['description'], $docs);
                }
            }

            // Sort products by TF-IDF score in descending order
            usort($products, function($a, $b) {
                return $b['tfidf'] <=> $a['tfidf'];
            });

            // Get top 10 recommended products
            $recommendedProducts = array_slice($products, 0, 10);
        }

        // Remove duplicates
        $recommendedProducts = array_map("unserialize", array_unique(array_map("serialize", $recommendedProducts)));

        return view('shop', [
            'products' => $products,
            'recommendedProducts' => $recommendedProducts,
            'banners' => $data['banners']
        ]);
    }

    public function addToCart($productId)
    {
        $session = session();
        $userId = $session->get('user_id'); // Pastikan Anda memiliki user_id di session

        if (!$userId) {
            return redirect()->to('/login'); // Redirect ke halaman login jika user belum login
        }

        $product = $this->productModel->find($productId);

        if ($product) {
            $existingCart = $this->cartModel->where('user_id', $userId)
                                            ->where('product_id', $productId)
                                            ->first();

            if ($existingCart) {
                // Update quantity if product is already in cart
                $this->cartModel->update($existingCart['id'], [
                    'quantity' => $existingCart['quantity'] + 1
                ]);
            } else {
                // Add new product to cart
                $this->cartModel->insert([
                    'user_id'    => $userId,
                    'product_id' => $productId,
                    'quantity'   => 1
                ]);
            }
        }

        return redirect()->to('/cart');
    }

    public function increaseQuantity($productId)
    {
        $session = session();
        $userId = $session->get('user_id');

        log_message('debug', 'User ID: ' . $userId);
        log_message('debug', 'Product ID: ' . $productId);

        if (!$userId) {
            log_message('error', 'User ID is not set in session.');
            return redirect()->to('/cart');
        }

        $cartItem = $this->cartModel->getCartItem($userId, $productId);

        log_message('debug', 'Cart Item: ' . json_encode($cartItem));

        if ($cartItem) {
            $this->cartModel->update($cartItem['id'], ['quantity' => $cartItem['quantity'] + 1]);
            log_message('debug', 'Updated quantity: ' . ($cartItem['quantity'] + 1));
        }else {
            log_message('error', 'Cart item not found.');
        }

        return redirect()->to('/cart');
    }

    public function decreaseQuantity($productId)
    {
        $session = session();
        $userId = $session->get('user_id');

        log_message('debug', 'User ID: ' . $userId);
        log_message('debug', 'Product ID: ' . $productId);

        if (!$userId) {
            log_message('error', 'User ID is not set in session.');
            return redirect()->to('/cart');
        }

        $cartItem = $this->cartModel->getCartItem($userId, $productId);

        log_message('debug', 'Cart Item: ' . json_encode($cartItem));

        if ($cartItem) {
            if ($cartItem['quantity'] > 1) {
                $this->cartModel->update($cartItem['id'], ['quantity' => $cartItem['quantity'] - 1]);
                log_message('debug', 'Updated quantity: ' . ($cartItem['quantity'] - 1));
            } else {
                $this->cartModel->delete($cartItem['id']);
                log_message('debug', 'Cart item deleted.');
            }
        } else {
            log_message('error', 'Cart item not found.');
        }

        return redirect()->to('/cart');
    }
    public function viewCart()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

// Fetch cart items for the user
        $cartItems = $this->cartModel->getCartByUserId($userId);
        $cart = [];

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        foreach ($cartItems as $item) {
            $product = $this->productModel->find($item['product_id']);
            $cart[] = [
                'id'       => $item['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'quantity' => $item['quantity'],
                'image'    => $product['image'],
                'product_id' => $item['product_id']
            ];
        }

        return view('cart', ['cart' => $cart, 'totalPrice' => $totalPrice]);
    }

    public function removeItem($cartId)
    {
        $this->cartModel->delete($cartId);

        return redirect()->to('/cart');
    }


    public function checkout()
    {
       
        $session = session();
        $userId = $session->get('user_id');
        $payment = $this->request->getPost('payment');

        if (!$userId) {
            log_message('error', 'User ID is not set in session.');
            return redirect()->to('/cart');
        }

        $cartItems = $this->cartModel->getCartByUserId($userId);
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        if ($payment < $totalPrice) {
            return redirect()->to('/cart')->with('error', 'Payment amount is less than total price.');
        }

        // Save order to database
        $this->orderModel->saveOrder($userId, $cartItems, $totalPrice, $payment);

        // Clear the cart
        $this->cartModel->where('user_id', $userId)->delete();

        return redirect()->to('/cart')->with('success', 'Order placed successfully!');
    }

    public function orderSuccess()
    {
        return view('order_success');
    }
    public function search()
    {
        $session = session();
        $userId = $session->get('user_id');

        $searchTerm = $this->request->getGet('q');

        if ($userId && $searchTerm) {
            $this->searchHistoryModel->save([
                'user_id' => $userId,
                'search_term' => $searchTerm,
                'searched_at' => date('Y-m-d H:i:s')
            ]);
        }

        $products = $this->productModel->like('name', $searchTerm)
                                        ->orLike('description', $searchTerm)
                                        ->orLike('sport_type', $searchTerm)
                                        ->findAll();

        return view('search_results', ['products' => $products, 'searchTerm' => $searchTerm]);
    }

}
