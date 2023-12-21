<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Explanner extends Controller
{
    public function index()
    {
        $content = view('explanner');
        $anotherJS = '<script src="/assets/js/explanner.js"></script>';
        $data = [
            "title_page" => "Explanner",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getDocument()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_subject WHERE ss_subject_name = 'Explanner' ");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

}