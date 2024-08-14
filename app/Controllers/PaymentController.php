<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\CartModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Midtrans;
use Midtrans\Snap;
use App\Models\OrderModel;
use Config\Services;

class PaymentController extends Controller
{
    protected $transactionModel;
    protected $cartModel;
    protected $userModel;
    protected $orderModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->cartModel = new CartModel();
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();

        $midtrans = new Midtrans();

        // Mengatur konfigurasi Midtrans
        \Midtrans\Config::$serverKey = $midtrans->serverKey;
        \Midtrans\Config::$isProduction = $midtrans->isProduction;
        \Midtrans\Config::$clientKey = $midtrans->clientKey;
    }

    public function checkout(){
        $session = session();
    $userId = $session->get('user_id');
    $address = $this->request->getPost('address');
    $totalPrice = $this->request->getPost('total_price');
    $cartItems = $this->cartModel->getCartByUserId($userId);

    // Save address to session
    $session->set('shipping_address', $address);

    return view('payment/index', [
        'cartItems' => $cartItems,
        'totalPrice' => $totalPrice,
        'address' => $address
    ]);
    }

    public function index()
    {
        return view('payment/index');
    }

    public function getToken()
    {
        $session = session();
        $userId = $session->get('user_id');

        // Fetch cart items for the user
        $cartItems = $this->cartModel->getCartByUserId($userId);

        if (empty($cartItems)) {
            return $this->response->setJSON(['error' => 'Cart is empty'])->setStatusCode(400);
        }

        $grossAmount = 0;
        $items = [];
        
        foreach ($cartItems as $item) {
            $grossAmount += $item['price'] * $item['quantity'];
            $items[] = [
                'id'       => $item['product_id'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'name'     => $item['name']
            ];
        }

        $transactionDetails = [
            'order_id' => rand(),
            'gross_amount' => $grossAmount
        ];

        $customerDetails = [
            'first_name' => $session->get('first_name'),
            'last_name'  => $session->get('last_name'),
            'email'      => $session->get('email')
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $items
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            return $this->response->setJSON(['token' => $snapToken]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['error' => 'Failed to create snap token'])->setStatusCode(500);
        }
    }
    public function finish()
    {
        $result_data = $this->request->getPost('result_data');

        // Pastikan result_data tidak null dan merupakan string JSON yang valid
        if ($result_data && is_string($result_data)) {
            $result = json_decode($result_data, true);

            if (isset($result['status_code']) && $result['status_code'] == '200') {
                $session = session();
                $userId = $session->get('user_id');
                
                // Fetch cart items for the user
                $cartItems = $this->cartModel->getCartByUserId($userId);
                $shippingAddress = $session->get('shipping_address');     
                $data = [
                    'order_id' => $result['order_id'],
                    'user_id' => session()->get('user_id'),
                    'gross_amount' => $result['gross_amount'],
                    'transaction_status' => $result['transaction_status'],
                    'transaction_time' => $result['transaction_time'],
                    'payment_type' => $result['payment_type'],
                    'payment_code' => isset($result['payment_code']) ? $result['payment_code'] : null,
                    'pdf_url' => isset($result['pdf_url']) ? $result['pdf_url'] : null,
                ];

                $orderData = [
                    'user_id' => $userId,
                    'total_price' => $result['gross_amount'],
                    'payment' => $result['payment_type'],
                    'status' => 'Pesanan siap dikirim', // initial status
                    'created_at' => date('Y-m-d H:i:s'),
                    'shipping_address' => $shippingAddress // Save the address
                ];
    
                
                // Clear cart
                $this->cartModel->where('user_id', $userId)->delete();
                
                //Catat Transaksi dan Pesanan
                $this->orderModel->insertOrder($orderData);
                $this->transactionModel->saveTransaction($data);
                return view('payment/success', [
                    'result' => $result,
                    'cartItems' => $cartItems,
                    'address' => $shippingAddress
                ]);
            } else {
                // JSON decode error
                return redirect()->to('/payment/failed')->with('error', 'Invalid JSON data received.');
            }
        } else {
            // result_data is not valid
            return redirect()->to('/payment/failed')->with('error', 'Invalid payment data received.');
        }
    }

    public function success()
    {
        return view('payment/success');
    }

    public function failed()
    {
        return view('payment/failed');
    }
}
