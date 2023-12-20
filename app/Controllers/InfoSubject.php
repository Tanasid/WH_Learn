<?php namespace App\Controllers;

use CodeIgniter\Controller;

class InfoSubject extends Controller
{
    public function index()
    {
        $content = view('infoSubject');
        $anotherJS = '<script src="/assets/js/infoSubject.js"></script>';
        $data = [
            "title_page" => "Info Subject",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getDepartment()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT sd_id, sd_department_name, sd_status_flg
        FROM sys_department
        WHERE sd_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getSubject()
    {
        $ss_id = $this->request->getVar('ss_id');
        $db = \Config\Database::connect();
        // $query = $db->query("SELECT pd.spg_id, mm.smm_id, mm.smm_name
        //         FROM sys_permission_detail pd
        //         LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        //         LEFT JOIN sys_menu_detail md on pd.smd_id = md.smd_id
        //         LEFT JOIN sys_main_menu mm on mm.smm_id = md.smm_id
        //         WHERE pd.spg_id = $spg_id
        // 		GROUP BY mm.smm_id");
        $query = $db->query("SELECT ss_id, ss_subject_name
        FROM sys_subject
        WHERE ss_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

}