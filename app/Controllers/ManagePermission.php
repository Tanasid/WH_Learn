<?php

namespace App\Controllers;

use CodeIgniter\Controller;
// use App\Models\PermissionGroupModel;

class ManagePermission extends Controller
{
    public function index()
    {
        $content = view('managePermission');
        $anotherJS = '<script src="/assets/js/mngPermision.js"></script>';
        $data = [
            "title_page" => "ManagePermission",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);

        return $this->response->setContentType('text/html')->setBody($page);
    }


    public function getPermisGP()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT spg_id, spg_name, spg_status_flg
        FROM sys_permission_group 
        WHERE spg_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getPermisDetail()
    {

        $smm_id = $this->request->getVar('smm_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT pd.spd_id, pd.spg_id, pg.spg_name, pd.smd_id, md.smd_name, md.smd_link, pd.spd_status_flg, pd.spd_updated_date, pd.spd_updated_by
        FROM sys_permission_detail pd
        LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        LEFT JOIN sys_menu_detail md on pd.smd_id = md.smd_id
        WHERE pd.spg_id = $smm_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getMainMenu()
    {
        $spg_id = $this->request->getVar('spg_id');
        $db = \Config\Database::connect();
        // $query = $db->query("SELECT pd.spg_id, mm.smm_id, mm.smm_name
        //         FROM sys_permission_detail pd
        //         LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        //         LEFT JOIN sys_menu_detail md on pd.smd_id = md.smd_id
        //         LEFT JOIN sys_main_menu mm on mm.smm_id = md.smm_id
        //         WHERE pd.spg_id = $spg_id
        // 		GROUP BY mm.smm_id");
        $query = $db->query("SELECT smm_id, smm_name
        FROM sys_main_menu
        WHERE smm_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getSubMenuByMainSel()
    {
        $smm_id = $this->request->getVar('smm_id');
        $db = \Config\Database::connect();
        // $query = $db->query("SELECT pd.spg_id, md.smd_id, md.smd_name
        //         FROM sys_permission_detail pd
        //         LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        //         LEFT JOIN sys_menu_detail md on pd.smd_id = md.smd_id
        //         LEFT JOIN sys_main_menu mm on mm.smm_id = md.smm_id
        //         WHERE md.smm_id = $smm_id
		// 		GROUP BY md.smd_id");

        $query = $db->query("SELECT smd_id, smd_name
        FROM sys_menu_detail
        WHERE spd_status_flg = 1
        AND smm_id = $smm_id
        ORDER BY smd_order
        ");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function addPermis()
    {
        $session = session();
        $spg_id = $this->request->getPost('spg_id');
        // $smm_id = $this->request->getPost('smm_id');
        $smd_id = $this->request->getPost('smd_id');
        $date = date('Y-m-d H:i:s');
        $created_by = $session->get('emp_code');

        $db = \Config\Database::connect();

        $checkNameSub = $db->query("SELECT smd_id FROM sys_permission_detail WHERE smd_id = '$smd_id' AND spg_id = $spg_id");
        $resutlName = $checkNameSub->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Permission Name is 
            already exist']);
        }

        // $query = $db->query("INSERT INTO sys_menu_detail
        //     VALUES(smm_id = '$smm_id', smd_name = '$smd_name', smd_link = '$smd_link', smd_order = '$nextOrder', spd_created_date = '$date', spd_created_by = '$created_by', spd_updated_date = '$date', spd_updated_by = '$created_by' ");

        $query = $db->query("INSERT INTO sys_permission_detail (spg_id, smd_id, spd_status_flg, spd_created_date, spd_created_by, spd_updated_date, spd_updated_by)
        VALUES ('$spg_id', '$smd_id', 1, '$date', '$created_by', '$date', '$created_by')");

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Add Permission successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to Added Permission']);
        }
    }

    public function getStatus()
    {
        $spd_id = $this->request->getVar('spd_id');
        $db = \Config\Database::connect();
        // $query = $db->query("SELECT pd.spg_id, md.smd_id, md.smd_name
        //         FROM sys_permission_detail pd
        //         LEFT JOIN sys_permission_group pg ON pd.spg_id = pg.spg_id
        //         LEFT JOIN sys_menu_detail md on pd.smd_id = md.smd_id
        //         LEFT JOIN sys_main_menu mm on mm.smm_id = md.smm_id
        //         WHERE md.smm_id = $smm_id
		// 		GROUP BY md.smd_id");

        $query = $db->query("SELECT * FROM sys_permission_detail WHERE spd_id = $spd_id;
        ");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateStatusFlg()
    {
        $session = session();

        $spd_id = $this->request->getVar('spd_id');
        $spd_status_flg = $this->request->getVar('spd_status_flg');
        $smm_date = date('Y-m-d H:i:s');
        $smm_by = $session->get('emp_code');

        if ($spd_status_flg == 1) {
            $spd_status_flg = 0;
        } else if ($spd_status_flg == 0) {
            $spd_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_permission_detail SET spd_status_flg = ?, spd_updated_date = ?, spd_updated_by = ? WHERE spd_id = ?", [$spd_status_flg, $smm_date, $smm_by, $spd_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

}
