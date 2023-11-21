<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MainModel;
use Mpdf\Mpdf;

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
            $model = new MainModel();
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

