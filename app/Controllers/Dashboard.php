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

    public function getSubject()
    {
        $session = session();
        $su_id = $session->get('user_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT
                                ifo.su_id,
                                SUM( ifo.ifo_cru_time ) AS TotalCruTime,
                                SUM( ifo.ifo_full_time ) AS TotalFullTime,
                                CAST( CASE WHEN ifo.ifo_cru_time <> 0 THEN ( SUM( ifo.ifo_cru_time ) / SUM( ifo.ifo_full_time ) ) * 100 ELSE NULL END AS UNSIGNED ) AS summary 
                            FROM
                                info_overview ifo
                                LEFT JOIN sys_user su ON su.su_id = ifo.su_id
                                LEFT JOIN sys_subject ss ON ss.ss_id = ifo.ss_id 
                            WHERE
                                ifo.su_id = $su_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }
    
}
