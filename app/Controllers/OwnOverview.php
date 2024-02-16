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
        $su_id = $session->get('user_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT
                                ifo.su_id,
                                ifo.ss_id,
                                ss.ss_subject_name,
                                CAST( CASE WHEN ifo.ifo_cru_time <> 0 THEN ( ifo.ifo_cru_time / ifo.ifo_full_time ) * 100 ELSE NULL END AS UNSIGNED ) AS progress 
                            FROM
                                info_overview ifo
                                LEFT JOIN sys_user su ON su.su_id = ifo.su_id
                                LEFT JOIN sys_subject ss ON ss.ss_id = ifo.ss_id 
                            WHERE
                                ifo.su_id = $su_id");
        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }
}
