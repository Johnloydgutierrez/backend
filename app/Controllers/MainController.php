<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MainModel;

class MainController extends ResourceController
{
    public function getData()
    {
        $main = new MainModel();
        $data = $main->findAll();
        return $this->respond($data, 200);
    }

    public function save()
    {
        $data = $this->request->getPost();
        
        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(WRITEPATH . 'uploads', $imageName);

        $data['image'] = $imageName;

        $main = new MainModel();
        $result = $main->save($data);

        if ($result) {
            return $this->respond(['message' => 'Product saved successfully.'], 201);
        } else {
            return $this->respond(['error' => 'Unable to save product.'], 500);
        }
    }
}
