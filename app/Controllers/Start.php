<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Start extends Controller {
    public function index() {
        $content = view('start');

        $data = [
            "content" => $content,
        ];
        $page = view('start',$data);
        return $this->response->setContentType('text/html')->setBody($page);
        
    }

}