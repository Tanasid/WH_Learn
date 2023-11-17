<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ManageSubMenu extends Controller
{
    public function index()
    {
        $content = view('manageSubMenu');
        $anotherJS = '<script src="/assets/js/mngSubMenu.js"></script>';
        $data = [
            "title_page" => "ManageSubMenu",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);

        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getSubMenu()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT md.*, mm.smm_order 
        FROM sys_menu_detail md
        LEFT JOIN sys_main_menu mm on md.smm_id = mm.smm_id
        LEFT JOIN sys_permission_detail pd on pd.spd_status_flg = md.spd_status_flg
        GROUP BY md.smd_name
        ORDER BY mm.smm_order");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function getSubMenuByStatus()
    {
        $smd_id = $this->request->getVar('smdID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_menu_detail WHERE smd_id = $smd_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getMainMenu()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT smm_id, smm_name, smm_icon, smm_order
        FROM sys_main_menu 
        WHERE smm_status_flg = 1
        ORDER BY smm_order");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getSubMenuById()
    {
        $smd_id = $this->request->getVar('inpSel');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT md.*, mm.smm_order 
        FROM sys_menu_detail md
        LEFT JOIN sys_main_menu mm on md.smm_id = mm.smm_id
        LEFT JOIN sys_permission_detail pd on pd.spd_status_flg = md.spd_status_flg
        WHERE md.smm_id = $smd_id
        GROUP BY md.smd_name
        ORDER BY md.smd_order");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function updateStatusFlg()
    {
        $session = session();

        $smd_id = $this->request->getVar('smd_id');
        $smd_status_flg = $this->request->getVar('smd_status_flg');
        $smm_date = date('Y-m-d H:i:s');
        $smm_by = $session->get('emp_code');

        if ($smd_status_flg == 1) {
            $smd_status_flg = 0;
        } else if ($smd_status_flg == 0) {
            $smd_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_menu_detail SET spd_status_flg = ?, spd_updated_date = ?, spd_updated_by = ? WHERE smd_id = ?", [$smd_status_flg, $smm_date, $smm_by, $smd_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function editSubMenuById()
    {
        $smd_id = $this->request->getVar('smd_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT md.*, mm.smm_order 
        FROM sys_menu_detail md
        LEFT JOIN sys_main_menu mm on md.smm_id = mm.smm_id
        LEFT JOIN sys_permission_detail pd on pd.spd_status_flg = md.spd_status_flg
        WHERE md.smd_id = $smd_id
        GROUP BY md.smd_name
        ORDER BY md.smd_order");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function updateSubMenu()
    {
        $session = session();

        // Assuming you have received data from the POST request
        $smd_id = $this->request->getPost('smd_id');
        $smd_name = $this->request->getPost('smd_name');
        $smd_link = $this->request->getPost('smd_link');
        $smd_order = $this->request->getPost('smd_order');
        // $original_order = $smd_order;
        $spd_date = date('Y-m-d H:i:s');
        $spd_by = $session->get('emp_code');

        $db = \Config\Database::connect();
        $checkNameSub = $db->query("SELECT smd_name FROM sys_menu_detail WHERE smd_name = '$smd_name' AND smd_id <> $smd_id ");
        $resutlName = $checkNameSub->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sub menu name is 
            already exist']);
        }

        $checkNameCon = $db->query("SELECT smd_link FROM sys_menu_detail WHERE smd_link = '$smd_link' AND smd_id <> $smd_id ");
        $resutlNameCon = $checkNameCon->getResultArray();
        if (count($resutlNameCon) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sub menu controller is 
            already exist']);
        }

        // $checkCon = $db->query("SELECT smd_link FROM sys_menu_detail WHERE smd_link = '$smd_link' ");
        // $resutlCon = $checkCon->getResultArray();
        // if (count($resutlCon) >= 1) {
        //     return $this->response->setJSON(['success' => false, 'message' => 'Sub Menu Controller is 
        //     already exist']);
        // }

        // $updateOrderQuery = $db->query("UPDATE sys_menu_detail SET smd_order = (smd_order + 1) WHERE smd_id <> $smd_id AND smd_order >= $original_order");

        // if ($updateOrderQuery) {

        $query = $db->query("UPDATE sys_menu_detail
            SET smd_name = '$smd_name', smd_link = '$smd_link', smd_order = '$smd_order', spd_updated_date = '$spd_date', spd_updated_by = '$spd_by' WHERE smd_id = $smd_id ");

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Sub Menu']);
        }

        // }else {
        //     return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Sub Menu']);
        // }

    }

    public function addSubMenu()
    {
        $session = session();
        $smm_id = $this->request->getPost('selMainMenu');
        $smd_name = $this->request->getPost('inpName');
        $smd_link = $this->request->getPost('inpConName');
        $date = date('Y-m-d H:i:s');
        $created_by = $session->get('emp_code');

        $db = \Config\Database::connect();
        $queryOrder = $db->query("SELECT MAX(smd_order)+1 AS next_order FROM sys_menu_detail WHERE smm_id = $smm_id");
        $nextOrder = $queryOrder->getRow()->next_order;


        $checkNameSub = $db->query("SELECT smd_name FROM sys_menu_detail WHERE smd_name = '$smd_name' ");
        $resutlName = $checkNameSub->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sub menu name is 
            already exist']);
        }

        $checkNameCon = $db->query("SELECT smd_link FROM sys_menu_detail WHERE smd_link = '$smd_link' ");
        $resutlNameCon = $checkNameCon->getResultArray();
        if (count($resutlNameCon) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sub menu controller is 
            already exist']);
        }
        // $query = $db->query("INSERT INTO sys_menu_detail
        //     VALUES(smm_id = '$smm_id', smd_name = '$smd_name', smd_link = '$smd_link', smd_order = '$nextOrder', spd_created_date = '$date', spd_created_by = '$created_by', spd_updated_date = '$date', spd_updated_by = '$created_by' ");

        $query = $db->query("INSERT INTO sys_menu_detail (smm_id, smd_name, smd_link, smd_order,  spd_status_flg, spd_created_date, spd_created_by, spd_updated_date, spd_updated_by)
        VALUES ('$smm_id', '$smd_name', '$smd_link', '$nextOrder', 1, '$date', '$created_by', '$date', '$created_by')");

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Add Sub Menu successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to Added Sub Menu']);
        }
    }
}
