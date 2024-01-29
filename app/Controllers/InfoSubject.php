<?php

namespace App\Controllers;

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
        $db = \Config\Database::connect();
        $query = $db->query("SELECT ss_id, ss_subject_name
        FROM sys_subject
        WHERE ss_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getDepById()
    {

        $ss_id = $this->request->getVar('ss_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT iss.iss_id, ss.ss_id, ss.ss_subject_name, sd.sd_id, sd.sd_department_name, iss.iss_status_flg FROM info_system_subject iss LEFT JOIN sys_subject ss ON ss.ss_id = iss.ss_id LEFT JOIN sys_department sd ON sd.sd_id = iss.sd_id WHERE iss.sd_id = '$ss_id' ");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateStatusFlg()
    {
        $session = session();
        $iss_id = $this->request->getVar('iss_id');
        $iss_status_flg = $this->request->getVar('iss_status_flg');
        $iss_date = date('Y-m-d H:i:s');
        $iss_by = $session->get('emp_code');

        if ($iss_status_flg == 1) {
            $iss_status_flg = 0;
        } else if ($iss_status_flg == 0) {
            $iss_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE info_system_subject SET iss_status_flg = ?, iss_updated_date = ?, iss_updated_by = ? WHERE iss_id = ?", [$iss_status_flg, $iss_date, $iss_by, $iss_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function addInfoSubject()
    {
        $session = session();
        $su_id = $session->get('user_id');
        $ss_id = $this->request->getPost('ss_id');
        $sd_id = $this->request->getPost('sd_id');
        $date = date('Y-m-d H:i:s');
        $created_by = $session->get('emp_code');

        $db = \Config\Database::connect();

        $checkInfoList = $db->query("SELECT * FROM info_system_subject WHERE ss_id = '$ss_id' AND sd_id = $sd_id");
        $resutlInfo = $checkInfoList->getResultArray();
        if (count($resutlInfo) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Info subject is already exist' ]);
        }else {
            $query = $db->query("INSERT INTO info_system_subject (ss_id, sd_id, iss_status_flg, iss_created_date, iss_created_by, iss_updated_date, iss_updated_by)
            VALUES ('$ss_id', '$sd_id', 1, '$date', '$created_by', '$date', '$created_by')");

            if ($query) {
                $query = $db->query("INSERT INTO info_overview (su_id, ss_id) VALUES ('$su_id', '$ss_id')");
                return $this->response->setJSON(['success' => true, 'message' => 'Add info subject successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to Added info subject']);
            }
        }
    }


}
