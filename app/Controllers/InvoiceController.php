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
use Mpdf\Mpdf;

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
//
public function saveinvoice()
{
    $json = $this->request->getJSON();

    // Fetch data from models
    $categoryModel = new CategoryModel();
    $category = $categoryModel->find($json->category);

    $ebikeModel = new EbikeModel();
    $product = $ebikeModel->find($json->product);

    $ebikepartsModel = new PartsModel();
    $parts = $ebikepartsModel->find($json->parts);

    // Update quantities in EbikeModel
    $sales = new InvoiceModel();
    $productt = new EbikeModel();

    $id = $json->invoiceID;
    $invoiceData = $sales->where('invoiceID', $id)->findAll();

    foreach ($invoiceData as $item) {
        $productId = $item['productName'];
        $quantity = $item['quantity'];

        $productData = $productt->find($productId);
        $newQuantity = $productData['quantity'] - $quantity;

        $productt->update($productId, ['quantity' => $newQuantity]);
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
    $main->save($data);

    return $this->respond($data, 200);
}

public function generatepdf()
{
    $model = new InvoiceModel();
    $data = $model->findAll();

    $mpdf = new Mpdf();


    $header = '<h1>Your PDF Header</h1>';
    $footer = '<div style="text-align: center; font-style: italic;">Your PDF Footer</div>';

    $mpdf->setHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);

    $html = '<h2>Data from Database</h2>';
    foreach ($data as $row) {
        $html .= '<p>' . implode(', ', (array) $row) . '</p>';
    }
    $mpdf->WriteHTML($html);


    $mpdfContent = $mpdf->Output('', 'S');

    header('Content-Type: application/pdf');
    header('Content-Disposition: attach; filename="output.pdf"');
    header('Cache-Length: ' . strlen($mpdfContent));


    echo $mpdfContent;

}
}


