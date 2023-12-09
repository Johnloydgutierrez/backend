<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InvoiceModel;
use App\Models\PartsInvoiceModel;
use App\Models\EbikeModel;
use App\Models\PartsModel;
use App\Models\CategoryModel;

class InvoiceController extends BaseController
{
  use ResponseTrait;
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
            $ebikepartsModel = new PartsModel();
            $parts = $ebikepartsModel->find($json->parts);

            // Fetch the invoice data
            $sales = new InvoiceModel();
            $productt = new EbikeModel();

            $id = $json->invoiceID; // Assuming you have an 'invoiceId' in your JSON

            $d = $sales->where('id', $id)->findAll();

            foreach ($d as $v) {
                $pid = $v['productName'];
                $quantity = $v['quantity'];
                $h = $productt->where('id', $pid)->first();

                // Update the quantity in the EbikeModel
                $newQuantity = $h['quantity'] - $quantity;
                $productt->update($pid, ['quantity' => $newQuantity]);
            }

            // Save the invoice data
            $data = [
              'invoiceID' => $json->invoiceID,
                'customer' => $json->customer,
                'category' => $category['category_name'],
                'product' => $product['productName'],
                'quantity' => $json->quantity,
                'totalAmount' => $json->totalAmount,
                'parts' => $parts['name'],
                'quantityp' => $json->quantityp,
                'totalAmountp' => $json->totalAmountp,
                'grandAmountp' => $json->grandAmountp,
            ];

            $main = new InvoiceModel();
            $r = $main->save($data);

            return $this->respond($data, 200);
        }

      }
