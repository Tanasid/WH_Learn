<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SubMenuPermission extends Controller
{
    public function index()
    {
        $smmId = $this->request->getVar('smm_id'); // Get the smm_id parameter
        $session = session();
        $db = \Config\Database::connect();
        $query = $db->query("SELECT mm.smm_id, pd.smd_id, md.smd_name, md.smd_link
        FROM sys_permission_detail pd
        LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        LEFT JOIN sys_menu_detail md ON md.smd_id = pd.smd_id AND pd.spd_status_flg = md.spd_status_flg
        LEFT JOIN sys_main_menu mm ON mm.smm_id = md.smm_id
        WHERE mm.smm_id = ?
        AND pd.spd_status_flg = 1
        AND pd.spg_id = ?
        ORDER BY md.smd_order", [$smmId, $session->get('spg_id')]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }
}

