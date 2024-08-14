<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\OrderModel;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function generateReport()
    {
        $range = $this->request->getGet('range') ?? '1month';
        $dateRange = $this->getDateRange($range);
        $orders = $this->orderModel->getCompletedOrdersByDateRange($dateRange['start'], $dateRange['end']);

        // Debugging: Ensure orders are retrieved
        log_message('debug', 'Orders: ' . print_r($orders, true));

        $filename = 'sales_report_' . date('Ymd') . '.csv';
        $filepath = WRITEPATH . 'uploads/' . $filename;

        $file = fopen($filepath, 'w');

        // Write header
        fputcsv($file, ['Order ID', 'User ID', 'Total Price','Status', 'Date']);

        $totalSales = 0;

        // Write data rows
        foreach ($orders as $order) {
            fputcsv($file, [
                $order['id'],
                $order['user_id'],
                $order['total_price'],
                $order['status'],
                $order['created_at']
            ]);
            $totalSales += $order['total_price'];
        }

        // Write total sales
        fputcsv($file, []);
        fputcsv($file, ['Total Sales', $totalSales]);

        fclose($file);

        return $this->response->download($filepath, null)->setFileName($filename);
    }

    private function getDateRange($range)
    {
        $endDate = date('Y-m-d');
        switch ($range) {
            case '1day':
                $startDate = date('Y-m-d', strtotime('-1 day'));
                break;
            case '1week':
                $startDate = date('Y-m-d', strtotime('-1 week'));
                break;
            case '1month':
                $startDate = date('Y-m-d', strtotime('-1 month'));
                break;
            case '1year':
                $startDate = date('Y-m-d', strtotime('-1 year'));
                break;
            default:
                $startDate = date('Y-m-d', strtotime('-1 month'));
        }
        return ['start' => $startDate, 'end' => $endDate];
    }
    public function userOrders()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data['orders'] = $this->orderModel->where('user_id', $userId)->findAll();

        return view('order', $data);
    }

    public function adminOrders()
    {
        $data['orders'] = $this->orderModel->findAll();

        return view('admin/order', $data);
    }
    public function ownerOrders()
    {
        $data['orders'] = $this->orderModel->findAll();

        return view('owner/order', $data);
    }

    public function shipOrder($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order || $order['status'] !== 'Pesanan siap dikirim') {
            return redirect()->to('/admin/orders');
        }

        $this->orderModel->update($id, ['status' => 'Sedang dikirim']);

        return redirect()->to('/admin/orders');
    }

    public function receiveOrder($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order || $order['status'] !== 'Sedang dikirim') {
            return redirect()->to('/orders');
        }

        $this->orderModel->update($id, ['status' => 'Pesanan diterima']);

        return redirect()->to('/orders');
    }
}
