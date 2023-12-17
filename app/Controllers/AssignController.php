<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AssignModel;

class AssignController extends ResourceController
{
    use ResponseTrait;

    public function Assign()
    {
        $main = new AssignModel();
        $data = $main->findAll();
        return $this->respond($data, 200);
    }

    public function sve()
    {
            $json = $this->request->getJSON();
            $data = [
                'staff' => $json->staff,
                'description' => $json->description,
                'location' => $json->location,
                'contact' => $json->contact,
                'costumer' => $json->costumer,
            ];

            $main = new AssignModel();
            $r = $main->save($data);
            return $this->respond ($data, 200);
        }

    public function del()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $main = new AssignModel();
        $r = $main->delete($id);
        return $this->respond($r, 200);
    }


}
