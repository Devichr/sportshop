<?
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SearchHistoryModel;

class SearchController extends BaseController
{
    protected $productModel;
    protected $searchHistoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->searchHistoryModel = new SearchHistoryModel();
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
