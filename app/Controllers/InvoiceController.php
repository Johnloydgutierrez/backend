<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InvoiceModel;
use App\Models\InvoicepModel;
use App\Models\EbikeModel;
use App\Models\PartsModel;
use App\Models\CategoryModel;

class InvoiceController extends BaseController
{

  public function getInvoice()
  {
    $invo = new InvoiceModel();
    $data = $invo->findAll();
    return $this->response->setJSON($data, 200);
  }


  public function getEList()
  {
      $list = new EbikeModel();
      $data = $list->findAll();
      return $this->response->setJSON($data, 200);

    }

    public function getPartss()
    {
        $ptss = new PartsModel();
        $data = $ptss->findAll();
        return $this->response->setJSON($data, 200);

      }

      public function getCategory()
      {
          $cat = new CategoryModel();
          $data = $cat->findAll();
          return $this->response->setJSON($data, 200);

        }

      public function saveinvoice()
      {
        $json = $this->request->getJSON();
        $categoryModel = new CategoryModel();
           $category = $categoryModel->find($json->category);
$ebikeModel = new EbikeModel();
$product = $ebikeModel->find($json->product);

$data = [
    'date' => $json->date,
    'customer' => $json->customer,
    'category' => $category['category_name'],
    'product' => $product['productName'], // Assuming the column name is 'productName'
    'quantity' => $json->quantity,
    'totalAmount' => $json->totalAmount,
              ];

              $main = new InvoiceModel();
              $r = $main->save($data);
              return $this->respond ($data, 200);
          }

          public function saveinvoicep()
          {
            $json = $this->request->getJSON();
            $categoryModel = new CategoryModel();
               $category = $categoryModel->find($json->category);
    $ebikepartsModel = new PartsModel();
    $parts = $ebikepartsModel->find($json->parts);

    $data = [
        'datep' => $json->datep,
        'customerp' => $json->customerp,
        'categoryp' => $category['category_name'],
        'parts' => $parts['name'],
        'quantityp' => $json->quantity,
        'totalAmountp' => $json->totalAmount,
                  ];

                  $mainnn = new InvoicepModel();
                  $rpp = $mainnn->save($data);
                  return $this->respond ($data, 200);
              }


}
