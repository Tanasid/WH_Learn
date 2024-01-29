<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Menupermission extends Controller
{
    public function index()
    {
        $session = session();
        $db = \Config\Database::connect();
        $query = $db->query("SELECT mm.smm_id, mm.smm_name, mm.smm_icon, mm.smm_order
        FROM sys_permission_detail pd
        LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        LEFT JOIN sys_menu_detail md ON md.smd_id = pd.smd_id AND md.spd_status_flg = pd.spd_status_flg
        LEFT JOIN sys_main_menu mm ON mm.smm_id = md.smm_id
        WHERE pd.spg_id = ?
        AND mm.smm_status_flg = 1
        AND md.spd_status_flg = 1
        GROUP BY mm.smm_name
        ORDER BY mm.smm_order ASC", [$session->get('spg_id')] );

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }
}
