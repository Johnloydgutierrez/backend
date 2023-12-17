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

   
    $sales = new InvoiceModel();
    $productt = new PartsModel();

    $id = $json->invoiceID;
    $invoiceData = $sales->where('invoiceID', $id)->findAll();

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

    foreach ($invoiceData as $item) {
        $productId = $item['name'];
        $quantity = $item['quantityp'];

        $productData = $productt->find($productId);
        $newQuantity = $productData['quantity'] - $quantity;

        $productt->update($productId, ['quantityp' => $newQuantity]);
    }

   


    $main = new InvoiceModel();
    $main->save($data);

    return $this->respond($data, 200);
}

public function generatePdf(){
    $model = new InvoiceModel(); 
    $data = $model->findAll(); 

    // Load mPDF library
    $mpdf = new Mpdf();

    // Set your header and footer HTML content
    $header = '<h1 style="text-align: center;">NWOW</h1>';
    $footer = '<div style="text-align: center; font-style: italic;">Capio | Cruz | Gutierrez</div>';

    // Set header and footer
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);

    // Create PDF content
    $html = '<h2 style="text-align: center;">________________________________________________________</h2>';

    // Add a table
    $html .= '<table border="1" cellspacing="0" cellpadding="5">';
    
    // Add table headers
    $html .= '<tr>';
    foreach (array_keys((array)$data[0]) as $header) {
        $html .= '<th>' . $header . '</th>';
    }
    $html .= '</tr>';

    // Add table rows
    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ((array)$row as $value) {
            $html .= '<td>' . $value . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Add content to PDF
    $mpdf->WriteHTML($html);

    // Get the PDF content as a string
    $pdfContent = $mpdf->Output('', 'S'); // 'S' returns the PDF as a string

    // Send appropriate headers
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="invoice.pdf"');
    header('Content-Length: ' . strlen($pdfContent));

    // Output the PDF content
    echo $pdfContent;

}
}
