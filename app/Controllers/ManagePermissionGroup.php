<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PermissionGroupModel;

class ManagePermissionGroup extends Controller
{
    public function index()
    {
        $content = view('managePermissionGroup');
        $anotherJS = '<script src="/assets/js/mngPermissionGroup.js"></script>';
        $data = [
            "title_page" => "ManagePermissionGroup",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);

        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getPermisGroup()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_permission_group");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function getPermisGPByStatus()
    {
        $spg_id = $this->request->getVar('spgID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_permission_group WHERE spg_id = $spg_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function addPermisGP()
    {
        $session = session();
        $model = new PermissionGroupModel();

        $spg_name = $this->request->getPost('inpName');

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT spg_name FROM sys_permission_group WHERE spg_name = '$spg_name' ");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Permission Group Name is 
            already exist']);
        }

        $newData = [
            'spg_name' => $this->request->getPost('inpName'),
            'spg_status_flg' => 1,
            'spg_created_date' => date('Y-m-d H:i:s'),
            'spg_created_by' => $session->get('emp_code'),
            'spg_updated_date' => date('Y-m-d H:i:s'),
            'spg_updated_by' => $session->get('emp_code'),
            // ... other fields you want to update
        ];

        $model->insertPremissionGroup($newData); // Return JSON response
        return $this->response->setJSON(['success' => true, 'message' => 'Data has been inserted successfully.']);
    }

    public function updateStatusFlg()
    {
        $session = session();

        $spg_id = $this->request->getVar('spg_id');
        $spg_status_flg = $this->request->getVar('spg_status_flg');
        $smm_date = date('Y-m-d H:i:s');
        $smm_by = $session->get('emp_code');

        if ($spg_status_flg == 1) {
            $spg_status_flg = 0;
        } else if ($spg_status_flg == 0) {
            $spg_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_permission_group SET spg_status_flg = ?, spg_updated_date = ?, spg_updated_by = ? WHERE spg_id = ?", [$spg_status_flg, $smm_date, $smm_by, $spg_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function getPermisGPByID()
    {
        $spg_id = $this->request->getVar('spg_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_permission_group WHERE spg_id = ?", [$spg_id]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updatePermisGP()
    {
        $session = session();

        // Assuming you have received data from the POST request
        $spg_id = $this->request->getPost('spg_id');
        $spg_name = $this->request->getPost('spg_name');
        $spg_date = date('Y-m-d H:i:s');
        $spg_by = $session->get('emp_code');

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT spg_name FROM sys_permission_group WHERE spg_name = '$spg_name' AND spg_id <> $spg_id ");
        $ResultName = $checkName->getResultArray();
        if (count($ResultName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Permission Group Name is 
            already exist']);
        } else {
            $query = $db->query("UPDATE sys_permission_group
            SET spg_name = '$spg_name', spg_updated_date = '$spg_date', spg_updated_by = '$spg_by' WHERE spg_id = $spg_id");

            if ($query) {
                return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Permission Group']);
            }
        }
    }
}
