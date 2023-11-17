<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MainMenuModel;
// use App\Models\PermissionGroupModel;

class ManageMainMenu extends Controller
{
    public function index()
    {
        $content = view('manageMainMenu');
        $anotherJS = '<script src="/assets/js/mngMainMenu.js"></script>';
        $data = [
            "title_page" => "ManageMainMenu",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);

        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getMainMenu()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_main_menu");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getMainMenuByStatus()
    {
        $smm_id = $this->request->getVar('smmID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_main_menu WhERE smm_id = $smm_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function addMainMenu()
    {
        $session = session();
        $model = new MainMenuModel();
        $db = \Config\Database::connect();

        $smm_name = $this->request->getPost('inpName');
        $checkName = $db->query("SELECT smm_name FROM sys_main_menu WHERE smm_name = '$smm_name' ");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Main Menu Name is 
            already exist']);
        }
        $queryOrder = $db->query("SELECT MAX(smm_order)+1 as orderInsert FROM sys_main_menu");
        $result = $queryOrder->getRow();
        $newData = [
            'smm_name' => $this->request->getPost('inpName'),
            'smm_icon' => $this->request->getPost('inpIconName'),
            'smm_order' => $result->orderInsert,
            'smm_status_flg' => 1,
            'smm_created_date' => date('Y-m-d H:i:s'),
            'smm_created_by' => $session->get('emp_code'),
            'smm_updated_date' => date('Y-m-d H:i:s'),
            'smm_updated_by' => $session->get('emp_code'),
            // ... other fields you want to update
        ];

        $model->insertMainMenu($newData); // Return JSON response
        return $this->response->setJSON(['success' => true, 'message' => 'Data has been inserted successfully.']);
    }

    public function updateStatusFlg()
    {
        $session = session();
        $smm_id = $this->request->getVar('smmId');
        $smm_flg = $this->request->getVar('smmFlg');
        $su_date = date('Y-m-d H:i:s');
        $su_by = $session->get('emp_code');

        if ($smm_flg == 1) {
            $smm_flg = 0;
        } else if ($smm_flg == 0) {
            $smm_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_main_menu SET smm_status_flg = ?, smm_updated_date = ?, smm_updated_by = ? WHERE smm_id = ?", [$smm_flg,$su_date, $su_by, $smm_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function getMainMenuByID()
    {
        $smm_id = $this->request->getVar('smm_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT smm_id, smm_name, smm_icon, smm_order, smm_status_flg FROM sys_main_menu WHERE smm_id = ?", [$smm_id]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateMainMenu()
    {
        $session = session();

        // Assuming you have received data from the POST request
        $smm_id = $this->request->getPost('smm_id');
        $smm_name = $this->request->getPost('smm_name');
        $smm_icon = $this->request->getPost('smm_icon');
        $smm_order = $this->request->getPost('smm_order');
        $original_order = $smm_order;
        $smm_date = date('Y-m-d H:i:s');
        $smm_by = $session->get('emp_code');

        $db = \Config\Database::connect();

        // $checkData = $db->query("SELECT smm_id, smm_name FROM sys_main_menu WHERE smm_name = '$smm_name' AND smm_id = $smm_id AND smm_icon = '$smm_icon' AND smm_order = $smm_order ");
        // $resutlData = $checkData->getResultArray();
        // if (count($resutlData) >= 1) {
        //     return $this->response->setJSON(['success' => false, 'message' => 'The data has not been edited.']);
        // }

        $checkName = $db->query("SELECT smm_id, smm_name FROM sys_main_menu WHERE smm_name = '$smm_name' AND smm_id <> $smm_id");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Main Menu Name is 
            already exist']);
        }

        $query = $db->query("UPDATE sys_main_menu
            SET smm_name = '$smm_name', smm_icon = '$smm_icon', smm_order = $smm_order, smm_updated_date = '$smm_date', smm_updated_by = '$smm_by' WHERE smm_id = $smm_id");

        $updateOrderQuery = $db->query("UPDATE sys_main_menu SET smm_order = (smm_order + 1) WHERE smm_id <> $smm_id AND smm_order >= $original_order");

        if ($query && $updateOrderQuery) {
            return $this->response->setJSON(['success' => true, 'message' => 'Main Menu updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Main Menu']);
        }
    }
}
