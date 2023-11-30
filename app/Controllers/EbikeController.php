<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EbikeModel;
class EbikeController extends ResourceController
{
  public function save()
  {
    try{
          $json = $this->request->getJSON();
          $data = [
              'id' => $json->id,
              'productName' => $json->productName,
              'description' => $json->description,
              'category' => $json->category,
              'price' => $json->price,
          ];
          $main = new EbikeModel();
          $r = $main->save($data);

          // Add debugging
          error_log('Save successful: ' . print_r($data, true));

          return $this->respond($data, 200);
      } catch (Exception $e) {
          // Add debugging
          error_log('Error saving: ' . $e->getMessage());

          return $this->respond(['error' => $e->getMessage()], 500);
      }
      }

}
