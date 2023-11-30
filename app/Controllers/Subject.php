<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Subject  extends Controller
{
    public function index()
    {
        $content = view('subject');
        $anotherJS = '<script src="/assets/js/subject.js"></script>';
        $data = [
            "title_page" => "Department",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

}