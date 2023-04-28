<?php


namespace app\Controllers;

use app\models\DVD;
use app\models\Book;
use app\Core\Request;
use app\Core\Response;
use app\Core\Controller;
use app\models\Furniture;
use app\models\AllProducts;
use app\models\Abstracts\Product;
use app\Models\Abstracts\Products;

class ProductController extends Controller
{

    public  function productsList()
    {
        $product = new AllProducts;
        $products = $product->getAllData();
        return $this->render("products-list", ['products' => $products]);
    }


    public function addProduct(Request $request)
    {
        // $product = new Product;

        if ($request->isPost()) {
            $product = Product::getProductType($request->getBody()['productType']);
            $response = new Response;
            if ($product['status'] != false) {
                $productObj = $product['productObj'];
                $productObj->loadData($request->getBody());
                $productObj->attributes();
                if ($productObj->AddToDB()) {
                    return $response->json([
                        "status" => true,
                    ]);
                }
                return $response->json([
                    "status" => false,
                    "errors" => $productObj->errors
                ]);
            }
            return $response->json([
                "message" => $product['message']
            ]);
        }
        $products = new AllProducts;
        return $this->render(
            'add-product',
            [
                'model' => $products
            ]
        );
        // $furniture=New Furniture;
        // print_r($furniture->Add());
    }


    public  function deleteProduct(Request $request)
    {
        $product = new AllProducts;
        if ($request->isPost()) {
            print_r($product->loadData($request->getBody()));

            $product->delete();
        }
        header("Location: /");
    }
};
