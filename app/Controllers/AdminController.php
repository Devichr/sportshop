<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BannerModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $bannerModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->bannerModel = new BannerModel();
        helper(['url', 'form']);
    }

    public function dashboard()
    {
        return view('admin/dashboard');
    }

    public function manage_products()
    {
        $data['products'] = $this->productModel->get_all_products();
        return view('admin/products', $data);
    }

    public function add_product()
    {
        log_message('debug', 'Accessing add_product method');
        $data['categories'] = $this->categoryModel->get_all_categories();
        return view('admin/add_product', $data);
    }

    public function insert_product()
    {
        $imageFile = $this->request->getFile('image');
        $imageName = $imageFile->getRandomName();
        $imageFile->move(WRITEPATH . '../public/uploads', $imageName);

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'sport_type' => $this->request->getPost('sport_type'),
            'image' => $imageName,
            'category_id' => $this->request->getPost('category_id')
        ];

        $this->productModel->insert_product($data);
        return redirect()->to('admin/products');
    }

    public function edit_product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            $categoryModel = new \App\Models\CategoryModel();
            $categories = $categoryModel->findAll();
            return view('admin/edit_product', ['product' => $product, 'categories' => $categories]);
        }

        return redirect()->to('/admin/products')->with('error', 'Product not found');
    }

    public function update_product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->asObject()->find($id);

        if ($product) {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'category_id' => $this->request->getPost('category_id'),
            ];

            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hapus gambar lama
                $oldImagePath = WRITEPATH . '../public/uploads/' . $product->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Upload gambar baru
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . '../public/uploads', $newName);
                $data['image'] = $newName;
            }

            $productModel->update($id, $data);

            return redirect()->to('/admin/products')->with('message', 'Product has been updated');
        }

        return redirect()->to('/admin/products')->with('error', 'Product not found');
    }

    public function delete_product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            // Hapus file gambar dari directory
            $imagePath = WRITEPATH . '../public/uploads/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Hapus entri dari database
            $productModel->delete($id);

            return redirect()->to('/admin/products')->with('message', 'Product has been deleted');
        }

        return redirect()->to('/admin/products')->with('error', 'Product not found');
    }
    
    public function manage_categories()
    {
        $data['categories'] = $this->categoryModel->get_all_categories();
        return view('admin/categories', $data);
    }

    public function add_category()
    {
        return view('admin/add_category');
    }

    public function insert_category()
    {
        $data = ['name' => $this->request->getPost('name')];
        $this->categoryModel->insert($data);
        return redirect()->to('admin/categories');
    }

    public function edit_category($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if ($category) {
            return view('admin/edit_category', ['category' => $category]);
        }

        return redirect()->to('/admin/categories')->with('error', 'Category not found');
    }

    public function update_category($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if ($category) {
            $data = [
                'name' => $this->request->getPost('name')
            ];

            $categoryModel->update($id, $data);

            return redirect()->to('/admin/categories')->with('message', 'Category has been updated');
        }

        return redirect()->to('/admin/categories')->with('error', 'Category not found');
    }

    public function delete_category($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if ($category) {
            $categoryModel->delete($id);

            return redirect()->to('/admin/categories')->with('message', 'Category has been deleted');
        }

        return redirect()->to('/admin/categories')->with('error', 'Category not found');
    }

    public function manage_banners()
    {
        $data['banners'] = $this->bannerModel->get_all_banners();
        return view('admin/banners', $data);
    }

    public function add_banner()
    {
        return view('admin/add_banner');
    }

    public function insert_banner()
    {
        $imageFile = $this->request->getFile('image');
        $imageName = $imageFile->getRandomName();
        $imageFile->move(WRITEPATH . '../public/uploads', $imageName);

        $data = [
            'image' => $imageName,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        $this->bannerModel->insert($data);
        return redirect()->to('admin/banners');
    }

    public function edit_banner($id)
    {
        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($id);

        if ($banner) {
            return view('admin/edit_banner', ['banner' => $banner]);
        }

        return redirect()->to('/admin/banners')->with('error', 'Banner not found');
    }

    public function update_banner($id)
    {
        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($id);

        if ($banner) {
            $data = [
                'title' => $this->request->getPost('title')
            ];

            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hapus gambar lama
                $oldImagePath = WRITEPATH . '../public/uploads/' . $banner['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Upload gambar baru
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . '../public/uploads', $newName);
                $data['image'] = $newName;
            }

            $bannerModel->update($id, $data);

            return redirect()->to('/admin/banners')->with('message', 'Banner has been updated');
        }

        return redirect()->to('/admin/banners')->with('error', 'Banner not found');
    }

    public function delete_banner($id)
    {
        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($id);

        if ($banner) {
            // Hapus gambar dari directory
            $imagePath = WRITEPATH . '../public/uploads/' . $banner['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Hapus entri dari database
            $bannerModel->delete($id);

            return redirect()->to('/admin/banners')->with('message', 'Banner has been deleted');
        }

        return redirect()->to('/admin/banners')->with('error', 'Banner not found');
    }
}
