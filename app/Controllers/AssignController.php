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

      public function generatepdf() 
{ 
    $model = new PpoModel();
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

    $outputFilePath = 'path/to/output.pdf';  // Adjust the path where you want to save the PDF
    $mpdf->Output($outputFilePath, 'F');  // Save the PDF file

    return $outputFilePath;  // Return the path to the generated PDF
}
}
