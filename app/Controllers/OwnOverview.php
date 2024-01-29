<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class OwnOverview extends Controller
{
    public function index()
    {
        $content = view('ownOverview');
        $anotherJS = '<script src="/assets/js/ownOverview.js"></script>';
        $data = [
            "title_page" => "Own Overview",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        // $anotherJS
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function showProgress()
    {
        $session = session();
        $su_id = $session->get('su_id');
    }

}
