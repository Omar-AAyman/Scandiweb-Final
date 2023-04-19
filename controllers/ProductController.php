<?php


namespace app\Controllers;

use app\core\App;
use app\core\Request;
use app\core\Controller;
use app\core\Response;
use app\models\Product;

class ProductController extends Controller
{
   
    public  function productsList()
    {
        $product = new Product;
        $products = $product->getAllData();
        return $this->render("products-list", ['products' => $products]);
    }

    public  function addProduct(Request $request)
    {
        $product = new Product;
        $product->loadData($request->getBody());
        if ($request->isPost()) {
            $response = new Response;
            if ($product->validate() && $product->store()) {
                $products = $product->getAllData();
                return  $response->json([
                    "status" => true,
                ]);
            }
            return  $response->json([
                "status" => false,
                "errors" => $product->errors
            ]);

        }
        return $this->render(
            'add-product',
            [
                'model' => $product
            ]
        );
    }



    public  function deleteProduct(Request $request)
    {
        $product = new Product;
        if ($request->isPost()) {

            $product->loadData($request->getBody());
            $product->delete();
        }
        header("Location: /");
    }
};
