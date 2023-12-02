<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InvoiceModel;
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
              $data = [
                  'date' => $json->date,
                  'customer' => $json->customer,
                  'category' => $json->category,
                  'product' => $json->product,
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
                  $data = [
                      'datep' => $json->datep,
                      'customerp' => $json->customerp,
                      'categoryp' => $json->categoryp,
                      'parts' => $json->parts,
                      'quantityp' => $json->quantityp,
                      'totalAmountp' => $json->totalAmountp,
                  ];

                  $mainnn = new InvoicepModel();
                  $rpp = $mainnn->save($data);
                  return $this->respond ($data, 200);
              }


}
