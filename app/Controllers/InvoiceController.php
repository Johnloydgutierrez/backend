<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InvoiceModel;
use App\Models\ListModel;
use App\Models\PartsModel;

class InvoiceController extends BaseController
{

  public function getInvoice()
  {
    $inv = new InvoiceModel();
    $data = $inv->findAll();
    return $this->response->setJSON($data, 200);
  }


  public function getEList()
  {
      $list = new ListModel();
      $data = $list->findAll();
      return $this->response->setJSON($data, 200);

    }

    public function getPartss()
    {
        $ptss = new PartsModel();
        $data = $ptss->findAll();
        return $this->response->setJSON($data, 200);

      }

}
