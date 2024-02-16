<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DeptOverview extends Controller
{
    public function index()
    {
        $content = view('deptOverview');
        $anotherJS = '<script src="/assets/js/deptOverview.js"></script>';
        $data = [
            "title_page" => "Department Overview",
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
        $su_id = $session->get('user_id');
        $deptId = $this->request->getVar('deptID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT
                                su.sd_id,
                                ifo.su_id,
                                su.su_emp_code,
                                ss.ss_subject_name,
                                ifo.ifo_cru_time,
                                ifo.ifo_full_time,
                                CAST( CASE WHEN ifo.ifo_cru_time <> 0 THEN ( ifo.ifo_cru_time / ifo.ifo_full_time ) * 100 ELSE NULL END AS UNSIGNED ) AS summary 
                            FROM
                                info_overview ifo
                                LEFT JOIN sys_user su ON su.su_id = ifo.su_id
                                LEFT JOIN sys_subject ss ON ss.ss_id = ifo.ss_id
                                LEFT JOIN sys_department sd ON sd.sd_id = su.sd_id
                            WHERE su.su_id <> $su_id
                            AND sd.sd_id = $deptId
                            ORDER BY ifo.su_id");
        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }
    
    public function getDepartment()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT sd_id, sd_department_name FROM sys_department");
        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

}
