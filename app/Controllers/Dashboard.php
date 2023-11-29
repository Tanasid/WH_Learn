<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {   
        $content = view('dashboard');
        $anotherJS = '
        <script src="/assets/js/dashboard.js"></script>
        <script src="/assets/vendor/chart.js/Chart.min.js"></script>';

        // <script src="/assets/js/demo/chart-area-demo.js"></script>
        // <script src="/assets/js/demo/chart-pie-demo.js"></script>
        
        $data = [
            "title_page" => "Dashboard",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getView()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT COUNT(la_id) as QTY FROM log_active");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getUser()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT COUNT(su_emp_code) as QTY FROM sys_user");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    
}
