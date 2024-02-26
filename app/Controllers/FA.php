<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FA extends Controller
{
    public function index()
    {
        $content = view('FA');
        $anotherJS = '<script src="/assets/js/fa.js"></script>';
        $data = [
            "title_page" => "Factory Automation",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        // $anotherJS
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getDocument()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_subject WHERE ss_subject_name = 'FA' ");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function checkTimeContent()
    {
        $session = session();
        $emp_code = $session->get('emp_code');
        $date = date('Y-m-d H:i:s');
        $timeContent = $this->request->getPost('timeContent');
        $su_id = $this->request->getPost('su_id');
        $ss_id = $this->request->getPost('ss_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM info_overview WHERE su_id = $su_id and ss_id = $ss_id");
        $checkSubCurrent = $query->getResultArray();

        if (count($checkSubCurrent) == 0) {
            $query = $db->query("INSERT INTO info_overview (su_id, ss_id, ifo_updated_date, ifo_updated_by) VALUES ('$su_id', '$ss_id', '$date', '$emp_code')");
        }

            $checkSubCurrent = $query->getResultArray();
            $ifo_crutime = $checkSubCurrent[0]['ifo_cru_time'];
            if ($checkSubCurrent) {
                $ifo_id = $checkSubCurrent[0]['ifo_id'];

                if ($checkSubCurrent[0]['ifo_full_time'] != number_format($timeContent, 3) ) {
                    $time_format = number_format($timeContent, 3);
                    $queryTimeFull = $db->query("UPDATE info_overview SET ifo_full_time = $time_format WHERE ifo_id = $ifo_id ");
                    if ($queryTimeFull) {
                        return $this->response->setJSON(['success' => true, 'message' => 'Update FullTime OK!!!!']);
                    }
                } else {
                    return $this->response->setJSON(['success' => true, 'message' => 'Cannot Update is The FullTime duplicate', 'cru_time' => number_format($ifo_crutime, 3)]);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error Updated!!!']);
            }

        // return $this->response->setJSON($data);
    }

    public function updateTimeCurrent()
    {
        $session = session();
        $cru_time = $this->request->getPost('cru_time');
        $date = date('Y-m-d H:i:s');
        $su_by = $session->get('emp_code');
        $su_id = $this->request->getPost('su_id');
        $ss_id = $this->request->getPost('ss_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT ifo_id, ifo_cru_time FROM info_overview WHERE su_id = $su_id and  ss_id = $ss_id");
        $checkTimeCurrent = $query->getResultArray();
        $ifo_crutime = $checkTimeCurrent[0]['ifo_cru_time'];
        $ifo_id =  $checkTimeCurrent[0]['ifo_id'];

        if ($ifo_crutime < $cru_time) {
            $time_set = number_format($cru_time, 3);
            $queryCruTime = $db->query("UPDATE info_overview SET ifo_cru_time = $time_set, ifo_updated_date = '$date', ifo_updated_by = '$su_by' WHERE ifo_id = $ifo_id ");
            if ($queryCruTime) {
                return $this->response->setJSON(['success' => true, 'message' => 'Update CurrentTime OK!!!!', 'cru_time' => $cru_time]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Error Updated Time less then!!!']);
            }
        } else {
            number_format($ifo_crutime, 3);
            return $this->response->setJSON(['Message' => false, 'message' => 'The current time is less than the time previously recorded.', 'cru_time' => $ifo_crutime]);
        }
    }
}
