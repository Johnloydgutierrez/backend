<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EbikeModel;
class EbikeController extends ResourceController
{
  public function getData()
  {
      $main = new EbikeModel();
      $data = $main->findAll();
      return $this->respond($data, 200);
  }
  public function ebikecategGetData()
  {
      $main = new EbikeModel();
      $data = $main->findAll();
      return $this->respond($data, 200);
  }


  // public function save()
  // {
  //
  //     $data = $this->request->getPost();
  //
  //
  //     $image = $this->request->getFile('image');
  //     $imageName = $image->getRandomName();
  //     $image->move(WRITEPATH . 'uploads', $imageName);
  //
  //     $data['image'] = $imageName;
  //
  //     $main = new EbikeModel();
  //     $result = $main->save($data);
  //
  //     if ($result) {
  //         return $this->respond(['message' => 'Product saved successfully.'], 201);
  //     } else {
  //         return $this->respond(['error' => 'Unable to save product.'], 500);
  //     }
  // }

  public function categsave()
  {
      try {
          // Use CodeIgniter's file helper to handle file uploads
          $categImage = $this->request->getFile('categImage');

          // Use the provided image name
          $imageName = $categImage->getName();

          $data = [
              'productName' => $this->request->getPost('productName'),
              'description' => $this->request->getPost('description'),
              'category' => $this->request->getPost('category'),
                'quantity' => $this->request->getPost('quantity'),
              'price' => $this->request->getPost('price'),


              'categImage' => base_url() . $this->handleImageUpload($categImage, $imageName),

          ];

          $ebikemodel = new EbikeModel();
          $savedData = $ebikemodel->save($data);

          return $this->respond($savedData, 200);
      } catch (\Exception $e) {
          log_message('error', 'Error saving data:' . $e->getMessage());
          return $this->failServerError('An error occurred while saving the data.');
      }
  }

  public function handleImageUpload($categImage, $imageName)
  {
      $categImage->move(ROOTPATH . 'public/uploads/' , $imageName);
      return 'uploads/' .$imageName;
  }

  public function updateItem($id)
{
    $main = new EbikeModel();
    $data = $main->find($id);

    if (!$data) {
        return $this->respond(['error' => 'Item not found.'], 404);
    }

    // Get the new data from the request
    // $newData = $this->request->getRawInput();
    $data = [
        'productName' => $this->request->getVar('productName'),
        'description' => $this->request->getVar('description'),

        'category' => $this->request->getVar('category'),
        'categImage' => $this->request->getVar('categImage'),
        'price' => $this->request->getVar('price'),
    ];
    // Use the where clause to update the existing data
    $main->set($data)->where('ID', $id)->update();
    //
    // if ($main->affectedRows() > 0) {
    //     return $this->respond(['message' => 'Item updated successfully.'], 200);
    // } else {
    //     return $this->respond(['error' => 'Unable to update item.'], 500);
    // }

}

      public function generatepdf()
      {
          $model = new EbikeModel();
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
