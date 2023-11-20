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

